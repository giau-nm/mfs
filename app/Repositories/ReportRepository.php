<?php

namespace App\Repositories;

use App\Models\Report;
use InfyOm\Generator\Common\BaseRepository;
use App\Http\Validators\ReportValidator;

/**
 * Class ReportRepository
 * @package App\Repositories
 * @version August 9, 2018, 9:13 am UTC
 *
 * @method Report findWithoutFail($id, $columns = ['*'])
 * @method Report find($id, $columns = ['*'])
 * @method Report first($columns = ['*'])
*/
class ReportRepository extends BaseRepository
{
    use AppRepository;

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'project_id',
        'device_id',
        'content',
        'status'
    ];

    protected $acceptSortColumn = [
        'created_at'           => 'created_at',
        'projects.name'        => 'projects.name',
        'devices.name'         => 'devices.name',
        'users.name'         => 'users.name',
    ];
    protected $acceptSortOrder = ['asc', 'desc'];
    protected $acceptFindFields = ['content', 'reports.created_at', 'projects.name', 'devices.name', 'users.name'];

    const STATUS_SEARCH_ALL = 100;

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Report::class;
    }

    public function listReportStatus() {
        return [
            self::STATUS_SEARCH_ALL => trans('report.status.all'),
            Report::STATUS_CREATED => trans('report.status.created'),
            Report::STATUS_ACCPET => trans('report.status.accept'),
            Report::STATUS_SLOVED => trans('report.status.sloved'),
            Report::STATUS_REJECT => trans('report.status.reject'),
        ];
    }

    public function queryAndPaginate($request, $pagingNumber = PAGGING_NUMBER_DEFAULT) {
        $reportModel = $this->model->select('reports.*');

        $reportModel = $reportModel->leftJoin('projects', 'reports.project_id', '=', 'projects.id');
        $reportModel = $reportModel->leftJoin('devices', 'reports.device_id', '=', 'devices.id');
        $reportModel = $reportModel->leftJoin('users', 'reports.user_id', '=', 'users.id');

        if(!$request->user->isAdmin()) {
            $reportModel = $reportModel->where('user_id', $request->user->id);
        }
        $reportModel = $this->addQueryFilterStatus($reportModel, $request);
        $reportModel = $this->addQueryFind($reportModel, $request);
        $reportModel = $this->addQuerySort($reportModel, $request);

        $reportModel = $reportModel->paginate($pagingNumber);
        $reportModel->appends([
            'find'  => $request->find,
            'sort'  => $request->sort,
            'order' => $request->order,
            'status'=> $request->status
        ]);

        return $reportModel;
    }

    public function addQueryFilterStatus($reportModel, $request) {
        $status = intval(is_null($request->status) ? self::STATUS_SEARCH_ALL : $request->status);
        if (!in_array($status, array_keys($this->listReportStatus()))) $status = self::STATUS_SEARCH_ALL;

        if ($status != self::STATUS_SEARCH_ALL) {
            $reportModel = $reportModel->where('reports.status', $status);
        };
        return $reportModel;
    }

    public function addQueryFind($reportModel, $request) {
        if (is_null($request->find)) return $reportModel;
        $likeText = '%' . $request->find . '%';
        $fields = $this->acceptFindFields;
        $reportModel = $reportModel->where(function ($query) use ($likeText, $fields) {
            foreach ($fields as $field) {
                $query->orWhere($field, 'like', $likeText);
            }
            return $query;
        });
        return $reportModel;
    }

    public function addQuerySort($reportModel, $request) {
        $sortColumn = $request->sort;
        $sortOrder = $request->order;

        if(is_null($sortColumn) || !in_array($sortColumn, $this->acceptSortColumn)) return $reportModel;

        $sortOrder = in_array($sortOrder, $this->acceptSortOrder)? $sortOrder : 'DESC';
        switch ($sortColumn) {
            case 'created_at':
                return $reportModel->orderBy('reports.created_at', $sortOrder);
                break;
            case 'projects.name':
                return $reportModel->orderBy('projects.name', $sortOrder);
                break;
            case 'devices.name':
                return $reportModel->orderBy('devices.name', $sortOrder);
                break;
            case 'users.name':
                return $reportModel->orderBy('users.name', $sortOrder);
                break;
            default:
                return $reportModel;

        }
    }

    public function generateSortUrl($request) {
        $sortData = [
            'created_at' => [
                'url' => $request->fullUrlWithQuery(['sort' => 'created_at', 'order' => 'asc']),
                'class' => 'sort-by'
            ],
            'projects.name' => [
                'url' => $request->fullUrlWithQuery(['sort' => 'projects.name', 'order' => 'asc']),
                'class' => 'sort-by'
            ],
            'devices.name' => [
                'url' => $request->fullUrlWithQuery(['sort' => 'devices.name', 'order' => 'asc']),
                'class' => 'sort-by'
            ],
            'users.name' => [
                'url' => $request->fullUrlWithQuery(['sort' => 'users.name', 'order' => 'asc']),
                'class' => 'sort-by'
            ],
        ];

        $sort = $request->sort;
        $order = $request->order;
        if (in_array($sort, $this->acceptSortColumn) && in_array($order, $this->acceptSortOrder)) {
            $newOrder = $order == 'asc' ? 'desc' : 'asc';
            $sortData[$sort]['url'] = $request->fullUrlWithQuery(['sort' => $sort, 'order' => $newOrder]);
            $sortData[$sort]['class'] = 'sort-by-' . $order;
        }
        return $sortData;

    }

    public function validateCreateReport($params)
    {
        $reportValidator = new ReportValidator();
        $validator = $this->checkValidator($params, $reportValidator->validate());

        if ($validator->fails()) {
            return ['status' => STATUS_ERROR, 'errors' => $validator->errors()];
        }
        return ['status' => STATUS_SUCCESS];
    }

    public function getReportByDeviceId($request, $deviceId) {
        $reportModel = $this->model->select('reports.*');

        $reportModel = $reportModel->leftJoin('projects', 'reports.project_id', '=', 'projects.id');
        $reportModel = $reportModel->leftJoin('devices', 'reports.device_id', '=', 'devices.id');
        $reportModel = $reportModel->leftJoin('users', 'reports.user_id', '=', 'users.id');

        if(!$request->user->isAdmin()) {
            $reportModel = $reportModel->where('user_id', $request->user->id);
        }
        $reportModel = $reportModel->where('device_id', $deviceId);
        $reportModel = $reportModel->paginate(PAGGING_NUMBER_DEVICE_UPDATE, ['*'], KEY_PAGINATE_ALL_DEVICE);
        return $reportModel;
    }
}
