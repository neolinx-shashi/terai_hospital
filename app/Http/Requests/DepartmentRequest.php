<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
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
        return [
            'name' => 'required|unique:departments',
            'department_code' => 'required|unique:departments|max:255',
        ];
    }

     public function messages()
    {
        return [
            'name.required' => 'Department name is required',
            'department_code.required' =>'Department Code is required',
            'department_code.unique'=>'Code has already been taken'
        ];
    }
}
