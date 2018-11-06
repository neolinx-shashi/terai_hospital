<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
            //'last_name' => 'required|alpha',
            'age' => 'required|numeric',
            'permanent_address' => 'required',
            'gender' => 'required',
            'phone'=>'required',
            'department_id'=>'required',
            'doctor_id'=>'required',
            'appointment'=>'required'
            // 'symptoms'=>'required|max:120'

        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required',
            'first_name.alpha'=>'Only alpahbet  character allowed',
            'last_name.required'=>'Last name is required',
            'last_name.alpha'=>'Only alpahbet  character allowed',
            'age.required'=>'Age is required',
            'age.numeric'=>'Only Number are allowed',
            'permanent_address.required'=>'Address is required',
            'department_id.required'=>'Department is required',
            'doctor_id.required'=>'Doctor is Required',
            'appointment.required'=>'Appointment is required',
            // 'symptoms.required'=>'Symptoms is required',
            'gender.required'=>'Gender must be selected',
             'phone.required'=>'Contact Number is required',
           // 'phone.alpha_dash'=>'Only numbers and - are allowed',


        ];
    }
}
