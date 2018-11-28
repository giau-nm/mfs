<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * Class Request
 * @package App\Models
 * @version August 9, 2018, 3:19 am UTC
 *
 * @property integer user_id
 * @property integer project_id
 * @property integer device_id
 * @property integer status
 * @property integer is_long_time
 * @property string|\Carbon\Carbon start_time
 * @property string|\Carbon\Carbon end_time
 * @property string|\Carbon\Carbon actual_start_time
 * @property string|\Carbon\Carbon actual_end_time
 * @property string note
 */
class Request extends Model
{
    use SoftDeletes;

    public $table = 'requests';

    const CREATED_AT            = 'created_at';
    const UPDATED_AT            = 'updated_at';
    const LONG_TIME             = 1;
    const NOT_LONG_TIME         = 0;
    const NEW_REQUEST           = 1;
    const ACCEPT_REQUEST        = 2;
    const REJECT_REQUEST        = 3;


    protected $dates = ['deleted_at', 'start_time', 'end_time', 'actual_start_time', 'actual_end_time'];


    public $fillable = [
        'user_id',
        'project_id',
        'device_id',
        'status',
        'is_long_time',
        'start_time',
        'end_time',
        'actual_start_time',
        'actual_end_time',
        'note'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'project_id' => 'integer',
        'device_id' => 'integer',
        'status' => 'integer',
        'is_long_time' => 'integer',
        'note' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * Relation with User
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * Relation with User With Trashed
     */
    public function userWithTrashed()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->withTrashed();
    }

    /**
     * Relation with Project
     */
    public function project()
    {
        return $this->belongsTo('App\Models\Project', 'project_id', 'id');
    }

    /**
     * Relation with Project With Trashed
     */
    public function projectWithTrashed()
    {
        return $this->belongsTo('App\Models\Project', 'project_id', 'id')->withTrashed();
    }

    /**
     * Relation with Device
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id', 'id');
    }

    /**
     * Relation with Device With Trashed
     */
    public function deviceWithTrashed()
    {
        return $this->belongsTo('App\Models\Device', 'device_id', 'id')->withTrashed();
    }

    /**
     * Modify long time request data
     */
    public function getLongTimeText()
    {
        return $this->is_long_time == self::LONG_TIME ? __(REQUEST_LONG_TIME_TEXT[self::LONG_TIME]) :
                                                        __(REQUEST_LONG_TIME_TEXT[self::NOT_LONG_TIME]);
    }

    /**
     * Modify status request data
     */
    public function getStatusText($isOnlyText = true)
    {
        $after = '_html';
        if ($isOnlyText) $after = '';
        switch ($this->status) {
            case STATUS_REQUEST_NEW:
                return __(REQUEST_STATUS_TEXT[STATUS_REQUEST_NEW] . $after);
                break;
            case STATUS_REQUEST_ACCEPT:
                $endTime = Carbon::parse($this->end_time);
                if ($this->is_long_time == REQUEST_LONG_TIME || $endTime->gt(Carbon::now()->format('Y-m-d)')));
                    return __(REQUEST_STATUS_TEXT[self::ACCEPT_REQUEST] . $after);

                return __(REQUEST_STATUS_TEXT[self::ACCEPT_REQUEST] . '_out_of_date' . $after);
                break;
            case STATUS_REQUEST_PAID:
                return __(REQUEST_STATUS_TEXT[STATUS_REQUEST_PAID] . $after);
                break;
            case STATUS_REQUEST_REJECT:
                return __(REQUEST_STATUS_TEXT[STATUS_REQUEST_REJECT] . $after);
                break;
            default:
                return __(REQUEST_STATUS_TEXT[STATUS_REQUEST_NEW] . $after);
                break;
        }
    }

    public function getActualEndTime()
    {
        if($this->is_long_time == 1 || is_null($this->actual_start_time)) {
            return null;
        }
        if(!is_null($this->actual_start_time)) {
            return Carbon::parse($this->actual_start_time)->addDays(MAX_REQUEST_DATE);
        }
        return null;
    }

}
