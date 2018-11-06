<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWardRequest extends FormRequest
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
            'ward_name' => 'required'
           
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'ward_name.required' => 'Ward Name is required'
             
        ];
    }
}
