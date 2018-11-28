<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Repositories\DeviceRepository;
use App\Repositories\RequestRepository;
use App\Repositories\ReportRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Device;

class DeviceController extends AppBaseController
{
    /** @var  DeviceRepository */
    private $deviceRepository;
    private $requestRepository;
    private $reportRepository;

    public function __construct(DeviceRepository $deviceRepo, RequestRepository $requestRepo, ReportRepository $reportRepo)
    {
        $this->deviceRepository = $deviceRepo;
        $this->requestRepository = $requestRepo;
        $this->reportRepository = $reportRepo;
    }

    /**
     * Display a listing of the Device.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $pageTitle = trans('label.devices.lbl_device_list_heading');
        $this->deviceRepository->pushCriteria(new RequestCriteria($request));
        $devices = $this->deviceRepository->listDevices($request);
        if (!is_null($request->export) && $request->export == 1) {
            $heading = $this->deviceRepository->translateColumnHeadingExcel();
            $this->deviceRepository->toExport($heading, $devices->toArray());
        }
        $sortLinks = $this->deviceRepository->getSortData($request);
        $linkExport = $request->fullUrlWithQuery(['export' => 1]);
        return view('devices.index', compact('pageTitle', 'devices', 'sortLinks', 'linkExport'));
    }

    /**
     * Show the form for creating a new Device.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('deviceAdmin', Device::class);
        $pageTitle = trans('label.devices.lbl_device_create_heading');
        return view('devices.create', compact('pageTitle'));
    }

    /**
     * Store a newly created Device in storage.
     *
     * @param CreateDeviceRequest $request
     *
     * @return Response
     */
    public function store(CreateDeviceRequest $createRequest)
    {
        $pageTitle = trans('label.devices.lbl_device_create_heading');
        $this->authorize('deviceAdmin', Device::class);
        $input = $createRequest->all();

        if (isset($createRequest->validator) && $createRequest->validator->fails()) {
            $errors = $createRequest->validator->messages();
            return redirect()->to(route('devices.create'))->withInput($createRequest->input())
                                                          ->withErrors($errors)
                                                          ->with('pageTitle', $pageTitle);
        }

        $device = $this->deviceRepository->create($input);

        Flash::success(trans('label.devices.msg_device_save_success'));

        return redirect(route('devices.index'));
    }

    /**
     * Show the form for editing the specified Device.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $this->authorize('deviceAdmin', Device::class);
        $pageTitle = trans('label.devices.lbl_device_edit_heading');
        $device = $this->deviceRepository->findWithoutFail($id);
        if (empty($device)) {
            Flash::error(trans('label.devices.msg_device_not_found'));

            return redirect(route('devices.index'));
        }
        $listRequests = $this->requestRepository->getRequestByDeviceId($id);
        $listReports = $this->reportRepository->getReportByDeviceId($request, $id);

        return view('devices.edit', compact('pageTitle', 'listRequests', 'listReports'))->with('device', $device);
    }

    /**
     * Update the specified Device in storage.
     *
     * @param  int              $id
     * @param UpdateDeviceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDeviceRequest $request)
    {
        $this->authorize('deviceAdmin', Device::class);
        $pageTitle = trans('label.devices.lbl_device_edit_heading');
        $device = $this->deviceRepository->findWithoutFail($id);

        if (empty($device)) {
            Flash::error(trans('label.devices.msg_device_not_found'));

            return redirect(route('devices.index'));
        }
        if (isset($request->validator) && $request->validator->fails()) {
            $errors = $request->validator->messages();
            return redirect()->to(route('devices.edit', $device->id))->withInput($request->input())
                                                          ->withErrors($errors);
        }

        $device = $this->deviceRepository->update($request->all(), $id);

        Flash::success(trans('label.devices.msg_device_update_success'));

        return redirect(route('devices.index'));
    }

    /**
     * Remove the specified Device from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->authorize('deviceAdmin', Device::class);
        $device = $this->deviceRepository->findWithoutFail($id);

        if (empty($device)) {
            return response()->json(['status' => STATUS_ERROR, 'message' => trans('label.devices.msg_device_not_found')]);
        }

        $this->deviceRepository->delete($id);
        return response()->json(['status' => STATUS_SUCCESS, 'message' => trans('label.devices.msg_device_delete_success')]);
    }

    public function changeStatus($id, Request $request)
    {
        $this->authorize('deviceAdmin', Device::class);
        $device = $this->deviceRepository->findWithoutFail($id);

        if (empty($device)) {
            return response()->json(['status' => STATUS_ERROR, 'message' => trans('label.devices.msg_device_not_found')]);
        }
        $result = $this->deviceRepository->update(['status' => $request->status], $id);
        if ($result) {
            return response()->json(['status' => STATUS_SUCCESS, 'message' => trans('label.devices.msg_device_change_status_success')]);
        }
    }

    public function import(Request $request)
    {
        $this->authorize('deviceAdmin', Device::class);
        $pageTitle = trans('label.devices.lbl_device_edit_heading');


        return view('devices.import_jexcel', compact('pageTitle'));
    }

    public function importList(Request $request)
    {
        $this->authorize('deviceAdmin', Device::class);
        $pageTitle = trans('label.devices.lbl_heading_import_page');
        $fileCsv = $request->file;
        return view('devices.import', compact('pageTitle', 'fileCsv'));
    }

    public function getDataFileCsv(Request $request) {
        $this->authorize('deviceAdmin', Device::class);
        $data = $this->deviceRepository->getDataFileCsv($request);
        $this->deviceRepository->deleteOneDayOldFileCsv($request);
        return response()->json($data);
    }

    public function saveDataCsv(Request $request) {
        $this->authorize('deviceAdmin', Device::class);
        $result = $this->deviceRepository->saveDataCsv($request);
        return response()->json($result);
    }

    public function show(Request $request) {
        $response = ['status' => false, 'data' => []];
        $data = $this->deviceRepository->getDataDetail($request);
        if ($data) {
            $response['status'] = true;
            $response['data'] = view('devices.detail', compact('data'))->render();
        }else{
            $response['data'] = view('devices.modal_not_found')->render();
        }
        return response()->json($response);
    }
}
