<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMistakesRequest;
use App\Http\Requests\UpdateMistakesRequest;
use App\Repositories\MistakesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MistakesController extends AppBaseController
{
    /** @var  MistakesRepository */
    private $mistakesRepository;

    public function __construct(MistakesRepository $mistakesRepo)
    {
        $this->mistakesRepository = $mistakesRepo;
    }

    /**
     * Display a listing of the Mistakes.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->mistakesRepository->pushCriteria(new RequestCriteria($request));
        $mistakes = $this->mistakesRepository->all();

        return view('mistakes.index')
            ->with('mistakes', $mistakes);
    }

    /**
     * Show the form for creating a new Mistakes.
     *
     * @return Response
     */
    public function create()
    {
        return view('mistakes.create');
    }

    /**
     * Store a newly created Mistakes in storage.
     *
     * @param CreateMistakesRequest $request
     *
     * @return Response
     */
    public function store(CreateMistakesRequest $request)
    {
        $input = $request->all();

        $mistakes = $this->mistakesRepository->create($input);

        Flash::success('Mistakes saved successfully.');

        return redirect(route('mistakes.index'));
    }

    /**
     * Display the specified Mistakes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $mistakes = $this->mistakesRepository->findWithoutFail($id);

        if (empty($mistakes)) {
            Flash::error('Mistakes not found');

            return redirect(route('mistakes.index'));
        }

        return view('mistakes.show')->with('mistakes', $mistakes);
    }

    /**
     * Show the form for editing the specified Mistakes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $mistakes = $this->mistakesRepository->findWithoutFail($id);

        if (empty($mistakes)) {
            Flash::error('Mistakes not found');

            return redirect(route('mistakes.index'));
        }

        return view('mistakes.edit')->with('mistakes', $mistakes);
    }

    /**
     * Update the specified Mistakes in storage.
     *
     * @param  int              $id
     * @param UpdateMistakesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMistakesRequest $request)
    {
        $mistakes = $this->mistakesRepository->findWithoutFail($id);

        if (empty($mistakes)) {
            Flash::error('Mistakes not found');

            return redirect(route('mistakes.index'));
        }

        $mistakes = $this->mistakesRepository->update($request->all(), $id);

        Flash::success('Mistakes updated successfully.');

        return redirect(route('mistakes.index'));
    }

    /**
     * Remove the specified Mistakes from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $mistakes = $this->mistakesRepository->findWithoutFail($id);

        if (empty($mistakes)) {
            Flash::error('Mistakes not found');

            return redirect(route('mistakes.index'));
        }

        $this->mistakesRepository->delete($id);

        Flash::success('Mistakes deleted successfully.');

        return redirect(route('mistakes.index'));
    }
}
