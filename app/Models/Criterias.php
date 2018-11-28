<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Criterias
 * @package App\Models
 * @version November 26, 2018, 9:44 pm +07
 *
 * @property string ma
 * @property string tieu_chi_lon
 * @property string tieu_chi_nho
 * @property string dat_neu
 * @property string so_diem_duoc_neu_dat
 * @property string khong_dat_neu
 * @property string so_diem_mat_neu_khong_dat
 * @property string mac_loi_nghiem_trong
 * @property integer so_diem_mat_neu_mac_loi_nghiem_trong
 */
class Criterias extends Model
{
    use SoftDeletes;

    public $table = 'criterias';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
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
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ma' => 'string',
        'tieu_chi_lon' => 'string',
        'tieu_chi_nho' => 'string',
        'dat_neu' => 'string',
        'so_diem_duoc_neu_dat' => 'string',
        'khong_dat_neu' => 'string',
        'so_diem_mat_neu_khong_dat' => 'string',
        'mac_loi_nghiem_trong' => 'string',
        'so_diem_mat_neu_mac_loi_nghiem_trong' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
