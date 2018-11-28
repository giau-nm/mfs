<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Report
 * @package App\Models
 * @version August 9, 2018, 9:13 am UTC
 *
 * @property integer user_id
 * @property integer project_id
 * @property integer device_id
 * @property string content
 * @property integer status
 */
class Report extends Model
{
    use SoftDeletes;

    public $table = 'reports';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    const STATUS_CREATED = 1;
    const STATUS_ACCPET = 2;
    const STATUS_SLOVED = 3;
    const STATUS_REJECT = 0;



    public $fillable = [
        'user_id',
        'project_id',
        'device_id',
        'content',
        'status'
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
        'content' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function project()
    {
        return $this->belongsTo('App\Models\Project', 'project_id', 'id');
    }

    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function projectName() {
        $project = $this->project;

        return (is_null($project)) ? '' : $project->name;
    }

    public function deviceName() {
        $device = $this->device;

        return (is_null($device)) ? '' : $device->name;
    }

    public function userName() {
        $user = $this->user;

        return (is_null($user)) ? '' : $user->name;
    }

    public function statusString() {
        switch ($this->status) {
            case 0:
                return '<span class="label report_table_status-reject">' . trans('report.status.reject') . '</span>';
            case 1:
                return '<span class="label report_table_status-slove">' . trans('report.status.created') . '</span>';
            case 2:
                return '<span class="label .report_table_status-accept">' . trans('report.status.accept') . '</span>';
            case 3:
                return '<span class="label report_table_status-slove">' . trans('report.status.sloved') . '</span>';
            default:
                return '';
        }
    }
}
