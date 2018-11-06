<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IPatientHistoryRequest extends FormRequest
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
            'doctor_id' => 'required',
            'doctor_fee' => 'required|numeric',
            'appointment' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'doctor_id.required' => 'Doctor Name is Required!',
            'doctor_fee.required' => 'Doctor Fee is Required!',
            'doctor_fee.numeric' => 'Doctor Fee should be Numeric!',
            'appointment.required' => 'Appointment is Required!',
        ];
    }
}
