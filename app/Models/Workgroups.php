<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Workgroups
 * @package App\Models
 * @version November 26, 2018, 10:16 pm +07
 *
 * @property string ten
 * @property string tieu_de
 * @property string mo_ta
 */
class Workgroups extends Model
{
    use SoftDeletes;

    public $table = 'workgroups';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'ten',
        'tieu_de',
        'mo_ta'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ten' => 'string',
        'tieu_de' => 'string',
        'mo_ta' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
