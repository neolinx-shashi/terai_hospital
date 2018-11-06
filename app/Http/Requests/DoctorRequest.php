<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DoctorRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'department_id' => 'required',
            'contact_no'=>'required|numeric',
            'emergency_contact'=>'required|numeric',
            'nmc_no' => 'required|unique:doctors,nmc_no',
            'email' => 'required|email|unique:doctors,email',
            'address' => 'required',
            'normal_fee' => 'required|numeric',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First Name is required',
            'last_name.required' => 'Last name is required',
            'age.required' => 'Age is required',
            'department_id.required' => 'Department must be selected',
            'email.required' => 'Email is required',
            'email.unique' => 'Email Already taken',
            'nmc_no.required' => 'NMC is required',
            'nmc_no.unique' => 'NMC no Already taken',
            'contact_no.required' => 'Contact Number is required',
            'contact_no.numeric' => 'Only numeric character are allowed',
            'contact_no.size:11' => 'Minimum is 9 character in length',
            'gender.required' => 'Please Choose Your Gender',
            'address.required' => 'Address is required',
            'normal_fee.required' => 'Doctor Fee is required',
            'normal_fee.numeric' => 'Only numeric characters are allowed',
             'emergency_contact.required' => 'Emergency Contact Number is required',
            'emergency_contact.numeric' => 'Only numeric character are allowed',
        ];
    }


}