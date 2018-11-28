<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequestRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Repositories\RequestRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\DeviceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class RequestController extends AppBaseController
{
    /** @var  RequestRepository */
    private $requestRepository;

    public function __construct(RequestRepository $requestRepo, ProjectRepository $projectRepo, DeviceRepository $deviceRepo) {
        $this->requestRepository = $requestRepo;
        $this->projectRepository = $projectRepo;
        $this->deviceRepository  = $deviceRepo;
    }

    /**
     * Display a listing of the Request.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $pageTitle = __('request.pageTitle');
        $this->requestRepository->pushCriteria(new RequestCriteria($request));
        $requests   = $this->requestRepository->list($request);
        $sortLinks  = $this->requestRepository->getSortData($request);
        $listStatusText = $this->requestRepository->translateStatusText();
        $searchData = $request->searchData;
        if (!is_null($request->export) && $request->export == 1) {
            $heading = $this->requestRepository->getColumnHeadingExport();
            $this->requestRepository->toExport($heading, $requests->toArray());
            return redirect(route('requests.index'));
        }
        $linkExport = $request->fullUrlWithQuery(['export' => 1]);
        return view('requests.index', compact('pageTitle', 'sortLinks', 'searchData', 'linkExport'))
            ->with('requests', $requests)
            ->with('listStatusText', $listStatusText);
    }

    /**
     * Show the form for creating a new Request.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $deviceId = $request->device_id;
        $userId   = \Auth::user()->id;
        $projects = $this->projectRepository->pluck('name', 'id');
        $devices  = $deviceId;
        if (!isset($devices)) {
            $devices = $this->deviceRepository->findByField('status', STATUS_DEVICES_AVAIABLE)->pluck('name', 'id');
        }
        return view('requests.create', [
            'projects' => $projects,
            'devices'  => $devices
        ]);
    }

    /**
     * Store a newly created Request in storage.
     *
     * @param CreateRequestRequest $createRequest
     * @return Response
     */
    public function store(CreateRequestRequest $createRequest)
    {
        $responseData = [
            'status'  => STATUS_SUCCESS,
            'message' => null,
            'html'    => null
        ];
        try {
            $userId = \Auth::user()->id;
            if (isset($createRequest->validator) && $createRequest->validator->fails()) {
                session()->flashInput($createRequest->all());
                $deviceId = $createRequest->query('device_id');
                $projects = $this->projectRepository->findByField('manager', $userId)->pluck('name', 'id');
                $devices  = $deviceId;
                if (!isset($devices)) {
                    $devices = $this->deviceRepository->findByField('status', STATUS_DEVICES_AVAIABLE)->pluck('name', 'id');
                }
                $viewContent = \View::make('requests.create', [
                    'errors'   => $createRequest->validator->messages(),
                    'projects' => $projects,
                    'devices'  => $devices
                ])->render();
                $responseData['status'] = STATUS_ERROR;
                $responseData['html']   = $viewContent;
                return response()->json($responseData);
            }
            $input                   = $createRequest->all();
            $input['user_id']        = $userId;
            $input['status']         = STATUS_REQUEST_NEW;
            $input['is_long_time']   = REQUEST_NOT_LONG_TIME;
            $request                 = $this->requestRepository->create($input);
            $viewContent             = \View::make('requests.table_row', ['request' => $request])->render();
            $responseData['message'] = trans('request.add_success');
            $responseData['html']    = $viewContent;
        } catch (\Exception $e) {
            $responseData['status']  = STATUS_ERROR;
            $responseData['message'] = $e->getMessage();
        }
        return response()->json($responseData);
    }

    /**
     * Display the specified Request.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $request = $this->requestRepository->findWithoutFail($id);

        if (empty($request)) {
            return view('requests.not_found');
        }

        return view('requests.show')->with('request', $request);
    }

    /**
     * Show the form for editing the specified Request.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $request = $this->requestRepository->findWithoutFail($id);

        if (empty($request)) {
            return view('requests.not_found');
        }
        return view('requests.edit')->with('request', $request);
    }

    /**
     * Update the specified Request in storage.
     *
     * @param  int $id
     * @param UpdateRequestRequest $updateRequest
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdateRequestRequest $updateRequest)
    {
        $this->authorize('requestAdmin', \App\Models\Request::class);
        $requestModel = $this->requestRepository->findWithoutFail($id);

        if (empty($requestModel)) {
            return response()->json([
                'status' => STATUS_ERROR,
                'message' => trans('request.notFound'),
                'html' => null
            ]);
        }
        $updateData = $updateRequest->all();
        if (isset($updateRequest->validator) && $updateRequest->validator->fails()) {
            session()->flashInput($updateData);
            return \View::make('requests.edit', [
                    'request' => $requestModel,
                    'errors' => $updateRequest->validator->messages()
                ])->render();
        };
        $updateResponse = $this->requestRepository->updateRequest($updateData, $requestModel);
        if ($updateResponse['status'] == STATUS_SUCCESS) {
            $this->requestRepository->sendMailAfterChangeStatus($updateData, $requestModel);
            $this->requestRepository->postChatWorkAfterChangeStatus($updateData, $requestModel);
        }
        return response()->json($updateResponse);
    }

    /**
     * Remove the specified Request from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $item = $this->requestRepository->findWithoutFail($id);

        if (empty($item)) {
            Flash::error(__('request.notFound'));

            return redirect(route('requests.index'));
        }

        if ((!$request->user->isAdmin() && $item->status == STATUS_REQUEST_NEW) || $request->user->isAdmin()) {
            $this->requestRepository->delete($id);
            Flash::success(__('request.deleteSuccess'));
            return redirect(route('requests.index'));
        } else {
            Flash::error(__('request.delete_permission_deny'));
            return redirect(route('requests.index'));
        }
    }

    public function info(Request $request)
    {
        $response = ['status' => false, 'data' => []];
        $request = $this->requestRepository->getCurrentRequestByDeviceId($request->get('device_id'));
        if (!empty($request)) {
            $response['status'] = true;
            $response['data'] = view('requests.show', compact('request'))->render();
        }else{
            $response['data'] = view('requests.not_found')->render();
        }
        return response()->json($response);
    }
}