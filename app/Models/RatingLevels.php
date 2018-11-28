<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RatingLevels
 * @package App\Models
 * @version November 26, 2018, 9:47 pm +07
 *
 * @property string ma
 * @property string ten
 * @property integer diem_tu
 * @property integer diem_den
 * @property string mo_ta
 */
class RatingLevels extends Model
{
    use SoftDeletes;

    public $table = 'rating_levels';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'ma',
        'ten',
        'diem_tu',
        'diem_den',
        'mo_ta'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ma' => 'string',
        'ten' => 'string',
        'diem_tu' => 'integer',
        'diem_den' => 'integer',
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
