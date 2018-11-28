<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorkgroupsRequest;
use App\Http\Requests\UpdateWorkgroupsRequest;
use App\Repositories\WorkgroupsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class WorkgroupsController extends AppBaseController
{
    /** @var  WorkgroupsRepository */
    private $workgroupsRepository;

    public function __construct(WorkgroupsRepository $workgroupsRepo)
    {
        $this->workgroupsRepository = $workgroupsRepo;
    }

    /**
     * Display a listing of the Workgroups.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->workgroupsRepository->pushCriteria(new RequestCriteria($request));
        $workgroups = $this->workgroupsRepository->all();

        return view('workgroups.index')
            ->with('workgroups', $workgroups);
    }

    /**
     * Show the form for creating a new Workgroups.
     *
     * @return Response
     */
    public function create()
    {
        return view('workgroups.create');
    }

    /**
     * Store a newly created Workgroups in storage.
     *
     * @param CreateWorkgroupsRequest $request
     *
     * @return Response
     */
    public function store(CreateWorkgroupsRequest $request)
    {
        $input = $request->all();

        $workgroups = $this->workgroupsRepository->create($input);

        Flash::success('Workgroups saved successfully.');

        return redirect(route('workgroups.index'));
    }

    /**
     * Display the specified Workgroups.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $workgroups = $this->workgroupsRepository->findWithoutFail($id);

        if (empty($workgroups)) {
            Flash::error('Workgroups not found');

            return redirect(route('workgroups.index'));
        }

        return view('workgroups.show')->with('workgroups', $workgroups);
    }

    /**
     * Show the form for editing the specified Workgroups.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $workgroups = $this->workgroupsRepository->findWithoutFail($id);

        if (empty($workgroups)) {
            Flash::error('Workgroups not found');

            return redirect(route('workgroups.index'));
        }

        return view('workgroups.edit')->with('workgroups', $workgroups);
    }

    /**
     * Update the specified Workgroups in storage.
     *
     * @param  int              $id
     * @param UpdateWorkgroupsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWorkgroupsRequest $request)
    {
        $workgroups = $this->workgroupsRepository->findWithoutFail($id);

        if (empty($workgroups)) {
            Flash::error('Workgroups not found');

            return redirect(route('workgroups.index'));
        }

        $workgroups = $this->workgroupsRepository->update($request->all(), $id);

        Flash::success('Workgroups updated successfully.');

        return redirect(route('workgroups.index'));
    }

    /**
     * Remove the specified Workgroups from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $workgroups = $this->workgroupsRepository->findWithoutFail($id);

        if (empty($workgroups)) {
            Flash::error('Workgroups not found');

            return redirect(route('workgroups.index'));
        }

        $this->workgroupsRepository->delete($id);

        Flash::success('Workgroups deleted successfully.');

        return redirect(route('workgroups.index'));
    }
}
