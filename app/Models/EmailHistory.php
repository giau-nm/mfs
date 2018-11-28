<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class EmailHistory
 * @package App\Models
 *
 * @property integer user_id
 * @property string user_email
 * @property integer type
 * @property integer status
 */
class EmailHistory extends Model
{
    public $table = 'email_histories';

    const STATUS_SUCCESS       = 1;
    const STATUS_ERROR         = 0;
    const TYPE_EXPIRED_REQUEST = 1;

    public $fillable = [
        'user_id',
        'user_email',
        'type',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'         => 'integer',
        'user_id'    => 'integer',
        'user_email' => 'string',
        'type'       => 'integer',
        'status'     => 'integer'
    ];
}
