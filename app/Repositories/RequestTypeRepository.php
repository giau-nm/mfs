<?php

namespace App\Repositories;

use App\Models\RequestType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RequestTypeRepository
 * @package App\Repositories
 * @version November 26, 2018, 9:37 pm +07
 *
 * @method RequestType findWithoutFail($id, $columns = ['*'])
 * @method RequestType find($id, $columns = ['*'])
 * @method RequestType first($columns = ['*'])
*/
class RequestTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ma',
        'tieu_de',
        'mo_ta',
        'chao_don_khach_hang',
        'nam_bat_nhu_cau',
        'dua_phuong_an_dung',
        'dien_dat',
        'thuyet_phuc',
        'y_thuc',
        'cam_on',
        'ghi_nhan_thong_tin'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RequestType::class;
    }
}
