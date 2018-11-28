<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateagentsRequest;
use App\Http\Requests\UpdateagentsRequest;
use App\Repositories\agentsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class agentsController extends AppBaseController
{
    /** @var  agentsRepository */
    private $agentsRepository;

    public function __construct(agentsRepository $agentsRepo)
    {
        $this->agentsRepository = $agentsRepo;
    }

    /**
     * Display a listing of the agents.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->agentsRepository->pushCriteria(new RequestCriteria($request));
        $agents = $this->agentsRepository->all();

        return view('agents.index')
            ->with('agents', $agents);
    }

    /**
     * Show the form for creating a new agents.
     *
     * @return Response
     */
    public function create()
    {
        return view('agents.create');
    }

    /**
     * Store a newly created agents in storage.
     *
     * @param CreateagentsRequest $request
     *
     * @return Response
     */
    public function store(CreateagentsRequest $request)
    {
        $input = $request->all();

        $agents = $this->agentsRepository->create($input);

        Flash::success('Agents saved successfully.');

        return redirect(route('agents.index'));
    }

    /**
     * Display the specified agents.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $agents = $this->agentsRepository->findWithoutFail($id);

        if (empty($agents)) {
            Flash::error('Agents not found');

            return redirect(route('agents.index'));
        }

        return view('agents.show')->with('agents', $agents);
    }

    /**
     * Show the form for editing the specified agents.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $agents = $this->agentsRepository->findWithoutFail($id);

        if (empty($agents)) {
            Flash::error('Agents not found');

            return redirect(route('agents.index'));
        }

        return view('agents.edit')->with('agents', $agents);
    }

    /**
     * Update the specified agents in storage.
     *
     * @param  int              $id
     * @param UpdateagentsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateagentsRequest $request)
    {
        $agents = $this->agentsRepository->findWithoutFail($id);

        if (empty($agents)) {
            Flash::error('Agents not found');

            return redirect(route('agents.index'));
        }

        $agents = $this->agentsRepository->update($request->all(), $id);

        Flash::success('Agents updated successfully.');

        return redirect(route('agents.index'));
    }

    /**
     * Remove the specified agents from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $agents = $this->agentsRepository->findWithoutFail($id);

        if (empty($agents)) {
            Flash::error('Agents not found');

            return redirect(route('agents.index'));
        }

        $this->agentsRepository->delete($id);

        Flash::success('Agents deleted successfully.');

        return redirect(route('agents.index'));
    }
}
