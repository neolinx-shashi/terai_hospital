<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WardRequest extends FormRequest
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
        $rules = [
            'ward_name' => 'required|unique:ward|min:3'
            // 'ward_desc' => 'required|max:100'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'ward_name.required' => 'Ward Name is required',
            'ward_name.unique' => 'Ward Name must be unique',
            'ward_name.required|min:3' => 'Ward Name is required',
            // 'ward_desc' => 'Ward Description is required',
        ];
    }
}
