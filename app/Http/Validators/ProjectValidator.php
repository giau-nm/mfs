<?php

namespace App\Http\Validators;

use Illuminate\Validation\Rule;

class ProjectValidator
{
    public function validate()
    {
        $res['rules'] = [
            'name'        => 'required|string|max:255',
            'manager'        => 'required|integer'
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
