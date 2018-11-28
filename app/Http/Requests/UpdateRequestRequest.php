<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Request;
use Illuminate\Contracts\Validation\Validator;

class UpdateRequestRequest extends FormRequest
{

    public $validator = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules                      = Request::$rules;
        $rules['status']            = 'required|in:' . STATUS_REQUEST_ACCEPT . ',' . STATUS_REQUEST_REJECT . ',' . STATUS_REQUEST_PAID;
        $rules['is_long_time']      = 'nullable|required|in:' . implode(',', array_keys(REQUEST_LONG_TIME_TEXT));
        $rules['actual_start_time'] = 'nullable|required_with:actual_end_time|date|date_format:Y-m-d|before_or_equal:' . date('Y-m-d');
        $rules['actual_end_time']   = 'nullable|date|date_format:Y-m-d|after_or_equal:actual_start_time';
        $rules['admin_note']        = 'nullable|max:255';

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}

