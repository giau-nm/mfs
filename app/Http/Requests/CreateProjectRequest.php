<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Project;
use Illuminate\Contracts\Validation\Validator;

class CreateProjectRequest extends FormRequest
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
        return Project::$rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}
