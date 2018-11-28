<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Device;
use Illuminate\Contracts\Validation\Validator;

class CreateDeviceRequest extends FormRequest
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
        $rules = Device::$rules;
        $rules['status'] = 'required|in:' . implode(',', array_keys(LIST_STATUS_DEVICES));
        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function sanitize()
    {
        $input = $this->all();
        $input = formatDataDevice($input);

        $this->replace(replaceTab2Space($input));
    }
}
