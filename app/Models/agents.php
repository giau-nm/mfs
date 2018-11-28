<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class agents
 * @package App\Models
 * @version November 26, 2018, 10:18 pm +07
 *
 * @property integer doanh_so
 * @property string ho_ten
 * @property string email
 * @property string so_dien_thoai
 */
class agents extends Model
{
    use SoftDeletes;

    public $table = 'agents';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'doanh_so',
        'ho_ten',
        'email',
        'so_dien_thoai'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'doanh_so' => 'integer',
        'ho_ten' => 'string',
        'email' => 'string',
        'so_dien_thoai' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
