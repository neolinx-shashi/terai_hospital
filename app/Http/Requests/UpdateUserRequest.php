<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateUserRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {


        $rules = [

            'fullname' => 'required',
            'contact_no' => 'required|min:9|numeric',
            'gender' => 'required',
            'address' => 'required',
            'user_post' => 'required'

        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'fullname.required' => 'FullName is required',
            'contact_no.required' => 'Contact Number is required',
            'contact_no.min:9'=>'Contact Number must be minimum 9 characters in length',
            'contact_no.numeric'=>'Only numeric value are allowed',
            'gender.required' => 'Please Choose Your Gender',
            'address.required' => 'Address is required',
            'user_post.required' => 'User Designation is required'

           


        ];
    }


}