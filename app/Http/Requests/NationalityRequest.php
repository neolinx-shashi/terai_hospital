<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NationalityRequest extends FormRequest
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
            'short_form_name' => 'required|unique:nationality|max:255',
            'country_name' => 'required',
            'calling_code' => 'required|unique:nationality|max:255',
        ];
    }

     public function messages()
    {
        return [
            'country_name.required' => 'Country name is required',
            'short_form_name.required' =>'Short Code is required',
            'short_form_name.unique'=>'Country Code already been taken',
            'calling_code.required' =>'Calling Code is required',
            'calling_code.unique'=>'Calling Code already been taken'
        ];
    }
}
