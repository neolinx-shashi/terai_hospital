<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmergencyUpdatePatientRequest extends FormRequest
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
            'gender' => 'required',
            'permanent_address' => 'required',
            'phone'=>'required',
            'nationality_id'=>'required',
            'bed_id'=>'required',
            'doctor_id'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required'=>'Last name is required',
            'gender.required'=>'Gender must be selected',
            'bloodGroup_id.required' => 'Blood Group must be selected',
            'permanent_address.required'=>'Permanent Address is required',
            'phone.required'=>'Contact Number is required',
            'nationality_id.required'=>'Nationality is required',
            'room_id.required'=>'Room is required',
            'bed_id.required'=>'Bed is required',
            'doctor_id.required'=>'Doctor is required'
        ];
    }
}
