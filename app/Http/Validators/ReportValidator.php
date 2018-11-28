<?php

namespace App\Http\Validators;

use Illuminate\Validation\Rule;
use App\Models\Project;
use App\Models\Device;

class ReportValidator
{
    public function validate()
    {
        $res['rules'] = [
            'project_id'     => [
                'required',
                Rule::in(Project::all()->pluck('id')->toArray())
            ],
            'device_id'      => [
                'required',
                Rule::in(Device::all()->pluck('id')->toArray())
            ],
            'content'        => 'required',
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
