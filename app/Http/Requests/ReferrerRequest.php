<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReferrerRequest extends FormRequest
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
            'institute_name' => 'required',
            'institute_address' => 'required',
            'medic_name' => 'required',
            'medic_designation' => 'required',
            'refer_reason' => 'required',
            'entry_date' => 'required',
            'release_date' => 'required',
        ];
    }
}
