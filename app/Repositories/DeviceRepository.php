<?php

namespace App\Repositories;

use App\Models\Device;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Support\Facades\DB;
use Excel;
use App\Http\Validators\DeviceValidator;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Repositories\AppRepository;
use Carbon\Carbon;

/**
 * Class DeviceRepository
 * @package App\Repositories
 * @version August 8, 2018, 9:13 am UTC
 *
 * @method Device findWithoutFail($id, $columns = ['*'])
 * @method Device find($id, $columns = ['*'])
 * @method Device first($columns = ['*'])
*/
class DeviceRepository extends BaseRepository
{
    use AppRepository;

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'status',
        'code',
        'screen_size',
        'os',
        'type',
        'manufacture',
        'carrier',
        'note',
        'phone_number',
        'imei',
        'udid',
        'serial',
        'checked_at'
    ];

    protected $fieldExportable = [
        'id',
        'name',
        'code',
        'status',
        'phone_number',
        'screen_size',
        'os',
        'type',
        'manufacture',
        'carrier',
        'imei',
        'udid',
        'serial',
        'checked_at',
        'note',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Device::class;
    }

    public function listDevices($request) {
        if (!is_null($request->q)) {
            $devices = $this->model->where('name', 'like', '%' . $request->q . '%')
                                   ->orWhere('code', 'like', '%' . $request->q . '%')
                                   ->orWhere('manufacture', 'like', '%' . $request->q . '%')
                                   ->orWhere('os', 'like', '%' . $request->q . '%');
            if (!$request->user->isAdmin()) {
                $devices = $devices->where('status', '!=', STATUS_DEVICES_BREAK);
            }
        } else {
            $devices = $this;
            if (!$request->user->isAdmin()) {
                $devices = $devices->scopeQuery(function ($query) {
                    return $query->where('status', '!=', STATUS_DEVICES_BREAK);
                });
            }
        }
        $acceptSortColumn = [
            'id'          => 'id',
            'name'        => 'name',
            'manufacture' => 'manufacture',
            'imei'        => 'imei',
            'udid'        => 'udid',
            'status'      => 'status',
            'os'          => 'os'
        ];
        $acceptSortOrder = ['asc', 'desc'];
        $sortColumn = $request->sort;
        $sortOrder = $request->order;
        if (isset($sortColumn) && isset($sortOrder) && array_key_exists($sortColumn, $acceptSortColumn) && in_array($sortOrder, $acceptSortOrder)) {
            $devices->orderBy($sortColumn, $sortOrder);
        } else {
            $devices->orderBy('id', 'ASC');
        }
        if (!is_null($request->export) && $request->export == 1) {
            $devices = $devices->get();
        } else {
            $devices = $devices->paginate(PAGGING_NUMBER_DEFAULT);
            $devices->appends([
                'q'     => $request->q,
                'sort'  => $request->sort,
                'order' => $request->order
            ]);
        }
        return $devices;

    }

    public function getSortData($request)
    {
        $sortData = [
            'id' => [
                'url' => $request->fullUrlWithQuery(['sort' => 'id', 'order' => 'asc']),
                'class' => 'sort-by'
            ],
            'name' => [
                'url' => $request->fullUrlWithQuery(['sort' => 'name', 'order' => 'asc']),
                'class' => 'sort-by'
            ],
            'manufacture' => [
                'url' => $request->fullUrlWithQuery(['sort' => 'manufacture', 'order' => 'asc']),
                'class' => 'sort-by'
            ],
            'os' => [
                'url' => $request->fullUrlWithQuery(['sort' => 'os', 'order' => 'asc']),
                'class' => 'sort-by'
            ],
            'imei' => [
                'url' => $request->fullUrlWithQuery(['sort' => 'imei', 'order' => 'asc']),
                'class' => 'sort-by'
            ],
            'udid' => [
                'url' => $request->fullUrlWithQuery(['sort' => 'udid', 'order' => 'asc']),
                'class' => 'sort-by'
            ],
            'status' => [
                'url' => $request->fullUrlWithQuery(['sort' => 'status','order' => 'asc']),
                'class' => 'sort-by'
            ]
        ];
        $sort = $request->sort;
        $order = $request->order;
        $acceptSortColumn = ['id', 'name', 'manufacture', 'imei', 'udid', 'status', 'os'];
        $acceptSortOrder = ['asc', 'desc'];
        if (in_array($sort, $acceptSortColumn) && in_array($order, $acceptSortOrder)) {
            $newOrder = $order == 'asc' ? 'desc' : 'asc';
            $sortData[$sort]['url'] = $request->fullUrlWithQuery(['sort' => $sort, 'order' => $newOrder]);
            $sortData[$sort]['class'] = 'sort-by-' . $order;
        }
        return $sortData;
    }

    public function updateListDevice($data) {
        try {
            foreach($data as $key => $row) {
                unset($row['errors']);
                $code = $row['code'];
                unset($row['code']);
                $row['checked_at'] = (isset($row['checked_at']) && $row['checked_at'] != '') ? $row['checked_at'] : null;
                $model = $this->model->withTrashed()->where('code', $code)->first();
                $model->deleted_at = (isset($row['deleted_at']) && !is_null($row['deleted_at'])) ? $row['deleted_at'] : null;
                $model->fill($row);
                $model->save();
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function createListDevice($data) {
        try {
            foreach ($data as $item) {
                unset($item['errors']);
                $this->model->create($item);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function importCSV($data) {
        DB::beginTransaction();
        try {
            
            $checkUpdate = false;
            if (!empty($data['listDataUpdate'])) {
                $checkUpdate = $this->updateListDevice($data['listDataUpdate']);
            }
            $checkCreate = false;
            if (!empty($data['listDataCreate'])) {
                $checkCreate = $this->createListDevice($data['listDataCreate']);
            }
            if ((!empty($data['listDataUpdate']) && $checkUpdate) || (!empty($data['listDataCreate']) && $checkCreate)) {
                DB::commit();
                return ['status' => STATUS_SUCCESS, 'message' => trans('label.devices.lbl_import_csv_success')];
            } else {
                DB::rollback();
                return ['status' => STATUS_ERROR, 'message' => trans('label.devices.lbl_import_csv_not_success')];
            }
        } catch (\Exception $e) {
            DB::rollback();
            return ['status' => STATUS_ERROR, 'message' => $e->getMessage()];
        }
    }

    public function validateImportCSV($request) {
        $deviceValidator = new DeviceValidator();
        $validator = $this->checkValidator($request->all(), $deviceValidator->validateFileCsv());

        if ($validator->fails()) {
            return ['status' => STATUS_ERROR, 'message' => implode("\n", $validator->errors()->all())];
        }
        $listCode = $this->model->withTrashed()->pluck('code')->toArray();
        $listDataCreate = [];
        $listDataUpdate = [];
        $checkCSV = true;
        $file = $request->file('file')->getRealPath();

        $dataCSV = $this->loadCSV2Array($file);

        foreach ($dataCSV as $key => $row) {
            $deviceValidator = new DeviceValidator();
            $validator = $this->checkValidator($row, $deviceValidator->validate());
            if ($validator->fails()) {
                $checkCSV = false;
                break;
            }
            if (in_array($row['code'], $listCode)) {
                $row['deleted_at'] = null;
                $listDataUpdate[] = $row;
            } else {
                unset($row['id']);
                $listDataCreate[] = $row;
            }
        }

        if (!$checkCSV) {
            $fileCsvName = 'device_csv_' . date('Y-m-d') . '_' . time() . '.csv';
            Storage::putFileAs('csv', new File($file), $fileCsvName);
            return ['status' => STATUS_ERROR, 'message' => trans('label.devices.lbl_import_csv_success_and_redirect'), 'link' => route('devices.importList') . '?file=' . $fileCsvName];
        } else {
            return ['status' => STATUS_SUCCESS, 'data' => ['listDataUpdate' => $listDataUpdate, 'listDataCreate' => $listDataCreate]];
        }
    }

    private function loadCSV2Array($file)
    {
        $arrayDataReturn = Excel::load($file)->get()->toArray();
        if (count($arrayDataReturn) < 1) return [];

        if (count(reset($arrayDataReturn)) == count($this->getColumnHeadingExport())) {
            $dataCsvArray = $arrayDataReturn;
        } else {
            $dataCsvArray = Excel::setDelimiter("	")->load($file)->get()->toArray();
        }

        $header2Column = $this->generateColumnNameImport();
        foreach ($dataCsvArray as $key => $row) {
            $dataCsvArray[$key] = $this->generateDataFromImport($row, $header2Column);
        }

        return $dataCsvArray;
    }

    private function generateDataFromImport($row, $header2Column)
    {
        $rowReturn = [];
        $arrayHeader = array_keys($header2Column);
        foreach ($row as $header => $value) {
            if (is_numeric($value)) $value = (integer)$value;
            if (in_array($header, $arrayHeader)) $rowReturn[$header2Column[$header]] = $value;
        }
        $rowReturn = formatDataDevice($rowReturn);
        return $rowReturn;
    }

    public function getDataFileCsv($request) {
        $csvFile = storage_path('app/csv/' . $request->file);
        $listDevices = [];
        $dataCsvArray = $this->loadCSV2Array($csvFile);

        foreach ($dataCsvArray as $key => $row) {
            $deviceValidator = new DeviceValidator();
            $row['checked_at'] = is_null($row['checked_at']) ? null : str_replace('/', '-', $row['checked_at']);
            $validator = $this->checkValidator($row, $deviceValidator->validate());
            if ($validator->fails()) {
                $row['errors'] = $validator->errors();
            }
            $listDevices[] = $row;
        }
        return $listDevices;
    }

    public function saveDataCsv($request) {
        $data = $this->addColumnName($request->data, $this->fieldExportable);

        DB::beginTransaction();
        try {
            $checkErrorData = false;
            $listDataUpdate = [];
            $listDataCreate = [];
            $listDevices = [];
            $listCodeCsv = array_map(function ($value) {
                return $value['code'];
            }, $data);
            $listCode = $this->model->withTrashed()->whereIn('code', $listCodeCsv)->pluck('code')->toArray();
            foreach ($data as $key => $item) {
                $deviceValidator = new DeviceValidator();
                $validator = $this->checkValidator($item, $deviceValidator->validate());
                if ($validator->fails()) {
                    $checkErrorData = true;
                    $item['errors'] = $validator->errors();
                }
                unset($item['id']);
                if (in_array($item['code'], $listCode)) {
                    $item['deleted_at'] = null;
                    $listDataUpdate[] = $item;
                } else {
                    $listDataCreate[] = $item;
                }
                $listDevices[] = $item;
            }
            if ($checkErrorData) {
                return ['status' => STATUS_ERROR, 'message' => trans('label.devices.lbl_import_csv_fail_input_again'), 'listDevices' => json_encode($listDevices)];
            } else {
                $checkUpdate = false;
                if (!empty($listDataUpdate)) {
                    $checkUpdate = $this->updateListDevice($listDataUpdate);
                }
                $checkCreate = false;
                if (!empty($listDataCreate)) {
                    $checkCreate = $this->createListDevice($listDataCreate);
                }
                if ((!empty($listDataUpdate) && $checkUpdate) || (!empty($listDataCreate) && $checkCreate)) {
                    DB::commit();
                    return ['status' => STATUS_SUCCESS, 'message' => trans('label.devices.lbl_import_csv_success'), 'link' => route('devices.index')];
                } else {
                    DB::rollback();
                    return ['status' => STATUS_ERROR, 'message' => trans('label.devices.lbl_import_csv_not_success'), 'listDevices' => json_encode($listDevices)];
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return ['status' => STATUS_ERROR, 'message' => $e->getMessage()];
        }
    }

    private function addColumnName($datas, $listColumnName)
    {
        $dataReturn = [];
        foreach ($datas as $key=>$data) {
            foreach ($data as $number => $value) {
                if (isset($listColumnName[$number])) $dataReturn[$key][$listColumnName[$number]] = $value;
            }

            $checkedAt = (isset($dataReturn[$key]['checked-at']))? $dataReturn[$key]['checked-at'] : null;
            $checkedAt = str_replace('/', '-', $checkedAt);
            if (!is_null($checkedAt)) $checkedAt = Carbon::parse($checkedAt)->format('Y-m-d');
            $dataReturn[$key]['checked-at'] = $checkedAt;

            foreach ($this->fieldExportable as $field) {
                if (!isset($dataReturn[$key][$field])) $dataReturn[$key][$field] = null;
            }
        }

        return $dataReturn;
    }

    public function getColumnHeadingExport()
    {
        return $this->translateColumn('label.devices.lbl_column_export');
    }

    public function translateColumnHeadingExcel()
    {
        return $this->translateColumn('label.devices.lbl_column_excel');
    }

    private function translateColumn($key)
    {
        $columns = [];
        foreach ($this->fieldExportable as $column) {
            $columns[$column] = trans($key . '_' . $column);
        }
        return $columns;
    }

    public function generateColumnNameImport()
    {
        $header2Column = [];
        foreach ($this->getColumnHeadingExport() as $column => $header) {
            $header = strtolower($this->utf8convert($header));
            $header = str_replace(array('%20', ' '), '_', $header);
            $header2Column[$header] = $column;
        }
        return $header2Column;

    }

    public function deleteOneDayOldFileCsv($request) {
        $filePath = storage_path('app/csv/');
        $listCsvFile = scandir($filePath);
        $now = Carbon::now();
        foreach ($listCsvFile as $fileName) {
            $listText = explode('_', $fileName);
            if (!isset($listText[2])) continue;

            $time = Carbon::parse($listText[2]);
            if ($time && $now->diffInDays($time)) {
                unlink($filePath . $fileName);
            }
        }
        return true;
    }

    private function utf8convert($str) {
        if(!$str) return false;
        $utf8 = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd'=>'đ|Đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach($utf8 as $ascii=>$uni) $str = preg_replace("/($uni)/i", $ascii, $str);

        return $str;
    }

    public function queryGenerateExcelData($request)
    {
        $devicesArr = $this->listDevices($request, null)->toArray();
        $heading = $this->translateColumnHeadingExcel();

        $dataReturn = [];
        $dataReturn['heading'] = array_values($heading);
        $columnKeys = array_keys($heading);
        foreach($devicesArr as $key => $item) {
            $mapping = $this->mappingColumn($columnKeys, $item);
            if (!empty($mapping)) {
                $dataReturn[] = array_replace(array_flip($columnKeys), $mapping);
            }
        }
        return $dataReturn;
    }

    public function getDataDetail($request){
        if ($request->has('device_id')){
            return $this->model->findOrFail($request->get('device_id'));
        }else{
            return false;
        }

    }
}
