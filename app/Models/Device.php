<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Device
 * @package App\Models
 * @version August 8, 2018, 9:13 am UTC
 *
 * @property string name
 * @property integer status
 * @property string code
 * @property string screen_size
 * @property string os
 * @property string type
 * @property string manufacture
 * @property string carrier
 * @property string note
 * @property string phone_number
 * @property string imei
 * @property string udid
 * @property string serial
 * @property string|\Carbon\Carbon checked_at
 */
class Device extends Model
{
    use SoftDeletes;

    public $table = 'devices';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['checked_at', 'deleted_at', 'updated_at', 'created_at'];


    public $fillable = [
        'name',
        'status',
        'code',
        'screen_size',
        'os',
        'type',
        'manufacture',
        'carrier',
        'note',
        'phone_number',
        'imei',
        'udid',
        'serial',
        'checked_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'status' => 'integer',
        'code' => 'string',
        'screen_size' => 'string',
        'os' => 'string',
        'type' => 'string',
        'manufacture' => 'string',
        'carrier' => 'string',
        'note' => 'string',
        'phone_number' => 'string',
        'imei' => 'string',
        'udid' => 'string',
        'serial' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'        => 'required|max:255',
        'code'        => 'required|max:45|unique:devices',
        'screen_size' => 'max:45',
        'os' => 'max:45',
        'type' => 'max:45',
        'manufacture' => 'max:45',
        'carrier' => 'max:45',
        'phone_number' => 'max:45',
        'imei' => 'max:45',
        'udid' => 'max:45',
        'serial' => 'max:45',
        'checked_at'      => 'required|date|date_format:Y-m-d'
    ];

    public function getStatusText() {
        if (isset(LIST_STATUS_DEVICES[$this->status]) && isset(LIST_CLASS_STATUS_DEVICES[$this->status])) {
            $classShowPopup = $this->status == STATUS_DEVICES_BUZY ? 'show_popup' : '';
            return '<span class="'.$classShowPopup.' label label-' . LIST_CLASS_STATUS_DEVICES[$this->status] . '">' . trans('label.devices.status.lbl_' . LIST_STATUS_DEVICES[$this->status]) . '</span>';
        }
        return false;
    }

    public function getCheckedAt()
    {
        if(!is_null($this->checked_at)) {
            return $this->checked_at->toDateString();
        }
        return null;
    }
}
