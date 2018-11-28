<?php

namespace App\Http\Validators;

use Illuminate\Validation\Rule;

class DeviceValidator
{
    public function validate()
    {
        $res['rules'] = [
            'name'        => 'required|max:255',
            'code'        => 'required|max:45',
            'status'        => 'required|in:' . implode(',', array_keys(LIST_STATUS_DEVICES)),
            'screen_size' => 'max:45',
            'os' => 'max:45',
            'type' => 'max:45',
            'manufacture' => 'max:45',
            'carrier' => 'max:45',
            'phone_number' => 'max:45',
            'imei' => 'max:45',
            'udid' => 'max:45',
            'serial' => 'max:45',
            'checked_at'      => 'nullable|date|date_format:Y-m-d'
        ];
        $res['messages'] = $this->_defaultMessage();
        $res['attributes'] = $this->_defaultAttribute();

        return $res;
    }

    public function validateFileCsv()
    {
        $res['rules'] = [
            'file'=>'required|mimes:csv,txt,application/vnd.ms-excel'
        ];
        $res['messages'] = $this->_defaultMessage();
        $res['attributes'] = $this->_defaultAttribute();

        return $res;
    }

    private function _defaultRule()
    {
        return [];
    }

    private function _defaultMessage()
    {
        return [];
    }

    private function _defaultAttribute()
    {
        return [];
    }
}
