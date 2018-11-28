<?php

namespace App\Repositories;

use App\Models\Criterias;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CriteriasRepository
 * @package App\Repositories
 * @version November 26, 2018, 9:44 pm +07
 *
 * @method Criterias findWithoutFail($id, $columns = ['*'])
 * @method Criterias find($id, $columns = ['*'])
 * @method Criterias first($columns = ['*'])
*/
class CriteriasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ma',
        'tieu_chi_lon',
        'tieu_chi_nho',
        'dat_neu',
        'so_diem_duoc_neu_dat',
        'khong_dat_neu',
        'so_diem_mat_neu_khong_dat',
        'mac_loi_nghiem_trong',
        'so_diem_mat_neu_mac_loi_nghiem_trong'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Criterias::class;
    }
}
