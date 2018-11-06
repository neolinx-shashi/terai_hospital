<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IPDAdmissionChargeRequest extends FormRequest
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
            'admission_charge' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'admission_charge.required' => 'This is required field',
        ];
    }
}
