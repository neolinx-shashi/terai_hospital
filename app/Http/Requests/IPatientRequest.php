<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IPatientRequest extends FormRequest
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
            //'doctor_fee' => 'required',
            //'last_name' => 'required',
            'age' => 'required',
            'gender' => 'required',
            //'bloodGroup_id' => 'required',
            'permanent_address' => 'required',
            //'temporary_address' => 'required',
            'phone' => 'required|numeric',
            'doctor_id' => 'required',
            'nationality_id' => 'required',
            //'marital_status'=>'required',
            'ward_id' => 'required',
            'room_id' => 'required',
            'bed_id' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'age.required' => 'Age is required',
            'gender.required' => 'Gender must be selected',
            'bloodGroup_id' => 'Blood Group must be selected',
            'permanent_address.required' => 'Permanent Address is required',
//            'temporary_address.required'=>'Temporary Address is required',
            'phone.required' => 'Phone is required',
            'phone.numeric' => 'Phone number should be number',
            //'phone.max' => 'Phone number should be less than 15 characters',
            'doctor_id.required' => 'Doctor is required',
            'nationality_id.required' => 'Nationality is required',
            'marital_status.required' => 'Marital Status must be selected',
            'description.required' => 'Description is required',
        ];
    }
}
