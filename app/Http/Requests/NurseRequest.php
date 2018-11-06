<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NurseRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'age' => 'required',
            'contact_no'=>'required',
            'emergency_contact'=>'required',
            'gender' => 'required',
            'nmc_no' => 'required|unique:nurses,nmc_no',
            'email' => 'required|email|unique:nurses,email',
            'address' => 'required',
            'department_id'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First Name is required',
            'last_name.required' => 'Last name is required',
            'age.required' => 'Age is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email Already taken',
            'nmc_no.required' => 'NMC is required',
            'nmc_no.unique' => 'NMC no Already taken',
            'contact_no.required'=>'Contact number is required',
            'emergency_contact.required'=>'Emergency Contact number is required',
            'gender.required' => 'Please Choose Your Gender',
            'address.required' => 'Address is required',


        ];
    }
}
