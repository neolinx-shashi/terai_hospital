<?php


namespace App\Http\Requests;

use App\Http\Requests\Request;

class ResetPasswordRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {


        $rules = [

            'new_password' => 'required|min:6'
           
        return $rules;
    }

    public function messages()
    {
        return [

            'new_password.required' => 'Password a required field.'
           


        ];
    }


}