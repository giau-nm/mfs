<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Results
 * @package App\Models
 * @version November 26, 2018, 9:49 pm +07
 *
 * @property integer ma
 * @property string ten
 * @property string mo_ta
 */
class Results extends Model
{
    use SoftDeletes;

    public $table = 'results';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'ma',
        'ten',
        'mo_ta'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ma' => 'integer',
        'ten' => 'string',
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
