<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Project;
use Illuminate\Contracts\Validation\Validator;

class UpdateProjectRequest extends FormRequest
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
        $request = request();
        $id = $request->input('id');
        $rules = Project::$rules;
        $rules['name'] = 'required|max:255|unique:projects,name,' . $id;
        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}
