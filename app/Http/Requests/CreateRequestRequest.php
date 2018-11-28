<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Request;
use App\Models\Project;
use App\Models\Device;
use Illuminate\Contracts\Validation\Validator;

class CreateRequestRequest extends FormRequest
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
        $rules               = Request::$rules;
        $userId              = \Auth::user()->id;
        $rules['project_id'] = 'nullable|in:' . implode(',', Project::pluck('id')->all());
        $rules['device_id']  = 'required|in:' . implode(',', Device::where('status', STATUS_DEVICES_AVAIABLE)->pluck('id')->all());
        $rules['start_time'] = 'required|date_format:Y-m-d|after_or_equal:today';
        $rules['end_time']   = 'required|date_format:Y-m-d|after_or_equal:start_time|max_date_request:start_time,' . MAX_REQUEST_DATE;
        $rules['note']       = 'max:255';

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}
