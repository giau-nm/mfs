<?php

namespace App\Http\Validators;

use Illuminate\Validation\Rule;
use App\Models\User;

class UserValidator
{
    public function validateChangePermission()
    {
        $listUserIdNotMe = User::where('id', '!=', \Auth::user()->id)
            ->get()
            ->pluck('id')
            ->toArray();
        $res['rules'] = [
            'listBecomeAdmin.*'  => Rule::in($listUserIdNotMe),
            'listBecomeNormal.*' => Rule::in($listUserIdNotMe),

        ];
        $res['messages'] = $this->_defaultMessage();
        $res['attributes'] = $this->_defaultAttribute();

        return $res;
    }

    public function validateFileCsv()
    {
        $res['rules'] = [
            'file'      => 'required|mimes:csv'
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
