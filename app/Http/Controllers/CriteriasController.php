<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCriteriasRequest;
use App\Http\Requests\UpdateCriteriasRequest;
use App\Repositories\CriteriasRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CriteriasController extends AppBaseController
{
    /** @var  CriteriasRepository */
    private $criteriasRepository;

    public function __construct(CriteriasRepository $criteriasRepo)
    {
        $this->criteriasRepository = $criteriasRepo;
    }

    /**
     * Display a listing of the Criterias.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->criteriasRepository->pushCriteria(new RequestCriteria($request));
        $criterias = $this->criteriasRepository->all();

        return view('criterias.index')
            ->with('criterias', $criterias);
    }

    /**
     * Show the form for creating a new Criterias.
     *
     * @return Response
     */
    public function create()
    {
        return view('criterias.create');
    }

    /**
     * Store a newly created Criterias in storage.
     *
     * @param CreateCriteriasRequest $request
     *
     * @return Response
     */
    public function store(CreateCriteriasRequest $request)
    {
        $input = $request->all();

        $criterias = $this->criteriasRepository->create($input);

        Flash::success('Criterias saved successfully.');

        return redirect(route('criterias.index'));
    }

    /**
     * Display the specified Criterias.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $criterias = $this->criteriasRepository->findWithoutFail($id);

        if (empty($criterias)) {
            Flash::error('Criterias not found');

            return redirect(route('criterias.index'));
        }

        return view('criterias.show')->with('criterias', $criterias);
    }

    /**
     * Show the form for editing the specified Criterias.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $criterias = $this->criteriasRepository->findWithoutFail($id);

        if (empty($criterias)) {
            Flash::error('Criterias not found');

            return redirect(route('criterias.index'));
        }

        return view('criterias.edit')->with('criterias', $criterias);
    }

    /**
     * Update the specified Criterias in storage.
     *
     * @param  int              $id
     * @param UpdateCriteriasRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCriteriasRequest $request)
    {
        $criterias = $this->criteriasRepository->findWithoutFail($id);

        if (empty($criterias)) {
            Flash::error('Criterias not found');

            return redirect(route('criterias.index'));
        }

        $criterias = $this->criteriasRepository->update($request->all(), $id);

        Flash::success('Criterias updated successfully.');

        return redirect(route('criterias.index'));
    }

    /**
     * Remove the specified Criterias from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $criterias = $this->criteriasRepository->findWithoutFail($id);

        if (empty($criterias)) {
            Flash::error('Criterias not found');

            return redirect(route('criterias.index'));
        }

        $this->criteriasRepository->delete($id);

        Flash::success('Criterias deleted successfully.');

        return redirect(route('criterias.index'));
    }
}
