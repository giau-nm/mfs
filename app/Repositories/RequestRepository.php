<?php

namespace App\Repositories;

use App\Models\Request;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Device;
use App\Libraries\Chatwork;
use App\Repositories\ConfigRepository;

/**
 * Class RequestRepository
 * @package App\Repositories
 * @version August 9, 2018, 3:19 am UTC
 *
 * @method Request findWithoutFail($id, $columns = ['*'])
 * @method Request find($id, $columns = ['*'])
 * @method Request first($columns = ['*'])
*/
class RequestRepository extends BaseRepository
{
    use AppRepository;

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'project_id',
        'device_id',
        'status',
        'is_long_time',
        'start_time',
        'end_time',
        'actual_start_time',
        'actual_end_time',
        'note'
    ];

    protected $fieldExportable = [
        'username',
        'project_name',
        'device_name',
        'status',
        'is_long_time',
        'start_time',
        'end_time',
        'actual_start_time',
        'actual_end_time',
        'note'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Request::class;
    }

    /**
     * Get list Requests
     *
     * @param  array $request
     * @return collection request
     **/
    public function list($request)
    {
        // Find all requests
        $requests = $this->model->select('requests.*', 'devices.name as device_name', 'users.name as username', 'projects.name as project_name')
                                ->join('devices', 'requests.device_id', '=', 'devices.id')
                                ->join('users', 'requests.user_id', '=', 'users.id')
                                ->leftJoin('projects', 'requests.project_id', '=', 'projects.id');
        if (!$request->user->isAdmin()) {
            $requests = $requests->where('requests.user_id', $request->user->id);
        }
        // Add condition incase have search data
        if (!is_null($request->searchData)) {
            $requests = $requests->where(function ($query) use ($request) {
                $query->where('devices.name', 'like', '%' . $request->searchData . '%')
                    ->orWhere('users.name', 'like', '%' . $request->searchData . '%')
                    ->orWhere('projects.name', 'like', '%' . $request->searchData . '%')
                    ->orWhere('devices.code', 'like', '%' . $request->searchData . '%')
                    ->orWhere('devices.manufacture', 'like', '%' . $request->searchData . '%')
                    ->orWhere('devices.os', 'like', '%' . $request->searchData . '%');
            });
        }

        if (!is_null($request->status)) {
            if (is_array($request->status)) {
                $requests = $requests->whereIn('requests.status', $request->status);
            } else {
                $requests = $requests->where('requests.status', $request->status);
            }

        }
        $acceptSortColumn = [
            'start_time'      => 'start_time',
            'end_time'        => 'end_time',
            'is_long_time'    => 'is_long_time',
            'requests.status' => 'requests.status',
            'devices.name'    => 'devices.name',
            'projects.name'   => 'projects.name',
            'users.name'      => 'users.name'
        ];

        $acceptSortOrder = ['asc', 'desc'];

        $sortColumn = $request->sort;
        $sortOrder  = $request->order;

        // Add condition incase have sort data
        if (isset($sortColumn) && isset($sortOrder) && array_key_exists($sortColumn, $acceptSortColumn) && in_array($sortOrder, $acceptSortOrder)) {
            $requests = $requests->orderBy($sortColumn, $sortOrder);
        } else {
            $requests = $requests->orderBy('requests.id', 'desc');
        }

        // Paginate requests
        if (!is_null($request->export) && $request->export == 1) {
            $requests = $requests->get();
        } else {
            $requests = $requests->paginate(PAGGING_NUMBER_DEFAULT);
        }

        return $requests;
    }

    /**
     * Get sort data
     *
     * @param  array $request
     * @return array
     */
    public function getSortData($request)
    {
        // List data can sort
        $sortData = [
            'users.name' => [
                'url'   => $request->fullUrlWithQuery(['sort' => 'users.name', 'order' => 'asc']),
                'class' => 'sort-by'
            ],
            'projects.name' => [
                'url'   => $request->fullUrlWithQuery(['sort' => 'projects.name', 'order' => 'asc']),
                'class' => 'sort-by'
            ],
            'devices.name' => [
                'url'   => $request->fullUrlWithQuery(['sort' => 'devices.name', 'order' => 'asc']),
                'class' => 'sort-by'
            ],
            'requests.status' => [
                'url'   => $request->fullUrlWithQuery(['sort' => 'requests.status', 'order' => 'asc']),
                'class' => 'sort-by'
            ],
            'is_long_time' => [
                'url'   => $request->fullUrlWithQuery(['sort' => 'is_long_time', 'order' => 'asc']),
                'class' => 'sort-by'
            ],
            'start_time' => [
                'url'   => $request->fullUrlWithQuery(['sort' => 'start_time', 'order' => 'asc']),
                'class' => 'sort-by'
            ],
            'end_time' => [
                'url'   => $request->fullUrlWithQuery(['sort' => 'end_time','order' => 'asc']),
                'class' => 'sort-by'
            ]
        ];

        $sort             = $request->sort;
        $order            = $request->order;
        $acceptSortColumn = ['start_time', 'end_time', 'is_long_time', 'requests.status', 'devices.name', 'projects.name', 'users.name'];
        $acceptSortOrder  = ['asc', 'desc'];

        // Change sort request
        if (in_array($sort, $acceptSortColumn) && in_array($order, $acceptSortOrder)) {
            $newOrder = $order == 'asc' ? 'desc' : 'asc';
            $sortData[$sort]['url']   = $request->fullUrlWithQuery(['sort' => $sort, 'order' => $newOrder]);
            $sortData[$sort]['class'] = 'sort-by-' . $order;
        }

        return $sortData;
    }

    /**
     * Get list expired requests
     **/
    public function expiredRequests()
    {
        $requests = $this->model->load(['user', 'device', 'project'])
            ->where('status', STATUS_REQUEST_ACCEPT)
            ->where('is_long_time', REQUEST_NOT_LONG_TIME)
            ->whereNull('actual_end_time')
            ->whereDate('end_time', '<=', Carbon::today()->toDateString());
        return $requests;
    }

    public function getColumnHeadingExport()
    {
        $columns = [];
        foreach ($this->fieldExportable as $column) {
            $columns[$column] = trans('request.lbl_column_' . $column);
        }
        return $columns;
    }

    public function listDevicesByUserId($userId)
    {
        $listStatusRequest = array_keys(REQUEST_STATUS_TEXT);
        $requests = $this->model->select('requests.*', 'devices.name as device_name', 'devices.code as device_code', 'users.name as username', 'projects.name as project_name')
                                ->join('devices', 'requests.device_id', '=', 'devices.id')
                                ->join('users', 'requests.user_id', '=', 'users.id')
                                ->leftJoin('projects', 'requests.project_id', '=', 'projects.id')
                                ->where(function ($query) use ($listStatusRequest, $userId) {
                                    return $query->where([
                                        'requests.user_id' => $userId,
                                        'requests.status' => $listStatusRequest[1]
                                    ])->whereNull('requests.actual_end_time');
                                })
                                ->orderBy('requests.id')
                                ->paginate(PAGGING_NUMBER_DEFAULT, ['*'], KEY_PAGINATE_ALL_DEVICE);
        return $requests;
    }

    public function listDevicesByExpiredUserId($userId)
    {
        $listStatusRequest = array_keys(REQUEST_STATUS_TEXT);
        $requests = $this->model->select('requests.*', 'devices.name as device_name', 'devices.code as device_code', 'users.name as username', 'projects.name as project_name')
                                ->join('devices', 'requests.device_id', '=', 'devices.id')
                                ->join('users', 'requests.user_id', '=', 'users.id')
                                ->leftJoin('projects', 'requests.project_id', '=', 'projects.id')
                                ->where(function ($query) use ($listStatusRequest, $userId) {
                                    return $query->where([
                                        'requests.user_id' => $userId,
                                        'requests.is_long_time' => 0,
                                        'requests.status' => $listStatusRequest[1]
                                    ])->where('requests.end_time', '<', \Carbon\Carbon::now()->toDateTimeString())
                                    ->whereNull('requests.actual_end_time');
                                })
                                ->orderBy('requests.id')
                                ->paginate(PAGGING_NUMBER_DEFAULT, ['*'], KEY_PAGINATE_ALL_DEVICE_EXPIRED);
        return $requests;
    }

    public function listRequestByUserId($userId)
    {
        $listStatusRequest = array_keys(REQUEST_STATUS_TEXT);
        $requests = $this->model->select('requests.*', 'devices.name as device_name', 'devices.code as device_code', 'users.name as username', 'projects.name as project_name')
                                ->join('devices', 'requests.device_id', '=', 'devices.id')
                                ->join('users', 'requests.user_id', '=', 'users.id')
                                ->leftJoin('projects', 'requests.project_id', '=', 'projects.id')
                                ->where(function ($query) use ($listStatusRequest, $userId) {
                                    return $query->where([
                                        'requests.user_id' => $userId,
                                        'requests.is_long_time' => 0,
                                        'requests.status' => $listStatusRequest[0]
                                    ])->where('requests.end_time', '>=', \Carbon\Carbon::now()->toDateTimeString())
                                    ->whereNull('requests.actual_end_time')
                                    ->whereNull('requests.actual_start_time');
                                })
                                ->orderBy('requests.id')
                                ->paginate(PAGGING_NUMBER_DEFAULT, ['*'], KEY_PAGINATE_ALL_REQUESTING);
        return $requests;
    }

    public function translateStatusText()
    {
        $listStatusText = [];
        foreach (REQUEST_STATUS_TEXT as $status => $text) {
            $listStatusText[$status] = trans($text);
        }
        return $listStatusText;
    }

    public function getRequestByDeviceId($deviceId)
    {
        $requests = $this->model->select('requests.*', 'users.name as username', 'projects.name as project_name')
                                ->join('devices', 'requests.device_id', '=', 'devices.id')
                                ->join('users', 'requests.user_id', '=', 'users.id')
                                ->leftJoin('projects', 'requests.project_id', '=', 'projects.id')
                                ->where(function ($query) use ($deviceId) {
                                    return $query->where('requests.device_id', $deviceId);
                                })
                                ->orderBy('requests.id')
                                ->paginate(PAGGING_NUMBER_DEVICE_UPDATE, ['*'], KEY_PAGINATE_ALL_REQUESTING);
        return $requests;
    }

    public function updateRequest($data, $requestModel)
    {
        DB::beginTransaction();
        try {
            $message = '';
            if (!$this->canUpdate($data, $requestModel, $message)) return ['status' => STATUS_ERROR, 'message' => $message, 'html' => null];

            $this->update($data, $requestModel->id);
            DB::commit();

            $requestModel = $this->model->find($requestModel->id);
            return [
                'status' => STATUS_SUCCESS,
                'message' => trans('request.updateSuccess'),
                'html' => $requestModel->getStatusText(false),
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'status' => STATUS_ERROR,
                'message' => $e->getMessage(),
                'html' => null
            ];
        }
    }

    public function canUpdate($data, $requestModel, &$message)
    {
        $deviceModal = Device::find($requestModel->device_id);
        if (is_null($deviceModal)) {
            $message = trans('request.msg.device_request_not_found');
            return false;
        }

        if ($data['status'] == $requestModel->status) {
            if (isset($data['actual_end_time']) && !isset($data['actual_start_time'])) {
                $message = trans('request.msg.must_set_actual_start_time');
                return false;
            }
            return true;
        }
        if ($data['status'] == STATUS_REQUEST_REJECT) return true;

        if ($data['status'] == STATUS_REQUEST_ACCEPT && ($requestModel->actual_start_time || $requestModel->actual_start_time)) {
            $message = trans('request.msg.cant_change_status_after_actualtime_set');
            return false;
        }

        if ($data['status'] == STATUS_REQUEST_ACCEPT && ($deviceModal->status == STATUS_DEVICES_BREAK || $deviceModal->status == STATUS_DEVICES_BUZY)) {
            $message = trans('request.msg.device_buzy_broken');
            return false;
        }

        return true;
    }

    public function sendMailAfterChangeStatus($data, $requestModel)
    {
        if ($data['status'] != $requestModel->status && ($data['status'] == STATUS_REQUEST_ACCEPT || $data['status'] == STATUS_REQUEST_REJECT)) {
            \Mail::send('requests.mail_approve', array('requestModel' => $requestModel, 'data' => $data), function ($message) use ($requestModel)
            {
                $message->from(MAIL_USERNAME);
                $message->to([$requestModel->user->email, \Auth::user()->email]);
                $message->cc(LIST_EMAIL_CC);
                $message->subject(trans('request.mail.subject'));
            });
        }
    }

    public function postChatWorkAfterChangeStatus($data, $requestModel)
    {
        if ($data['status'] != $requestModel->status && $data['status'] == STATUS_REQUEST_ACCEPT) {
            $cw = new Chatwork();
            if (!$cw->canPostMessage()) return false;

            $data = [
                'username'          => $requestModel->user->name,
                'device_name'       => $requestModel->device->name,
                'device_code'       => $requestModel->device->code,
                'start_time'        => is_null($requestModel->start_time) ? '' : $requestModel->start_time,
                'end_time'          => is_null($requestModel->end_time) ? '' : $requestModel->end_time,
                'is_long_time'      => $requestModel->is_long_time,
                'chatwork_id'       => $requestModel->user->chatwork_id
            ];
            try{
                $cw->postMessage($data);
                if (!is_null($data['chatwork_id'])) {
                    $cw->postTask($data);
                }
            } catch (\Exception $e) {
                return false;
            }
        }

    }

    public function getCurrentRequestByDeviceId($deviceId)
    {
        $requests = $this->model->select('requests.*', 'users.name as username')
            ->join('devices', 'requests.device_id', '=', 'devices.id')
            ->join('users', 'requests.user_id', '=', 'users.id')
            ->where(function ($query) use ($deviceId) {
                $query->where('requests.device_id', $deviceId);
                $query->where('requests.status', STATUS_REQUEST_ACCEPT);
                return $query;
            })
            ->orderBy('requests.id', 'DESC')
            ->first();
        return $requests;
    }
}