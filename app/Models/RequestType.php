<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RequestType
 * @package App\Models
 * @version November 26, 2018, 9:37 pm +07
 *
 * @property string ma
 * @property string tieu_de
 * @property string mo_ta
 * @property integer chao_don_khach_hang
 * @property integer nam_bat_nhu_cau
 * @property integer dua_phuong_an_dung
 * @property integer dien_dat
 * @property integer thuyet_phuc
 * @property integer y_thuc
 * @property integer cam_on
 * @property integer ghi_nhan_thong_tin
 */
class RequestType extends Model
{
    use SoftDeletes;

    public $table = 'request_types';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
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
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ma' => 'string',
        'tieu_de' => 'string',
        'mo_ta' => 'string',
        'chao_don_khach_hang' => 'integer',
        'nam_bat_nhu_cau' => 'integer',
        'dua_phuong_an_dung' => 'integer',
        'dien_dat' => 'integer',
        'thuyet_phuc' => 'integer',
        'y_thuc' => 'integer',
        'cam_on' => 'integer',
        'ghi_nhan_thong_tin' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
