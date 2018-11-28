<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequestTypeRequest;
use App\Http\Requests\UpdateRequestTypeRequest;
use App\Repositories\RequestTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class RequestTypeController extends AppBaseController
{
    /** @var  RequestTypeRepository */
    private $requestTypeRepository;

    public function __construct(RequestTypeRepository $requestTypeRepo)
    {
        $this->requestTypeRepository = $requestTypeRepo;
    }

    /**
     * Display a listing of the RequestType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->requestTypeRepository->pushCriteria(new RequestCriteria($request));
        $requestTypes = $this->requestTypeRepository->all();

        return view('request_types.index')
            ->with('requestTypes', $requestTypes);
    }

    /**
     * Show the form for creating a new RequestType.
     *
     * @return Response
     */
    public function create()
    {
        return view('request_types.create');
    }

    /**
     * Store a newly created RequestType in storage.
     *
     * @param CreateRequestTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateRequestTypeRequest $request)
    {
        $input = $request->all();

        $requestType = $this->requestTypeRepository->create($input);

        Flash::success('Request Type saved successfully.');

        return redirect(route('requestTypes.index'));
    }

    /**
     * Display the specified RequestType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $requestType = $this->requestTypeRepository->findWithoutFail($id);

        if (empty($requestType)) {
            Flash::error('Request Type not found');

            return redirect(route('requestTypes.index'));
        }

        return view('request_types.show')->with('requestType', $requestType);
    }

    /**
     * Show the form for editing the specified RequestType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $requestType = $this->requestTypeRepository->findWithoutFail($id);

        if (empty($requestType)) {
            Flash::error('Request Type not found');

            return redirect(route('requestTypes.index'));
        }

        return view('request_types.edit')->with('requestType', $requestType);
    }

    /**
     * Update the specified RequestType in storage.
     *
     * @param  int              $id
     * @param UpdateRequestTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRequestTypeRequest $request)
    {
        $requestType = $this->requestTypeRepository->findWithoutFail($id);

        if (empty($requestType)) {
            Flash::error('Request Type not found');

            return redirect(route('requestTypes.index'));
        }

        $requestType = $this->requestTypeRepository->update($request->all(), $id);

        Flash::success('Request Type updated successfully.');

        return redirect(route('requestTypes.index'));
    }

    /**
     * Remove the specified RequestType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $requestType = $this->requestTypeRepository->findWithoutFail($id);

        if (empty($requestType)) {
            Flash::error('Request Type not found');

            return redirect(route('requestTypes.index'));
        }

        $this->requestTypeRepository->delete($id);

        Flash::success('Request Type deleted successfully.');

        return redirect(route('requestTypes.index'));
    }
}
