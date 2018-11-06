<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardianRequest extends FormRequest
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
            'guardian_name' => 'required',
            'guardian_relation' => 'required',
            'guardian_phone' => 'required',
            'guardian_address' => 'required',
            'bloodGroup_id' => 'required',
            'parent_name' => 'required',
            'local_guardian' => 'required',
//            'parent_phone'=>'required',
//            'parent_email'=>'required',
            'parent_address'=>'required',
//            'parent_occupation'=>'required',
        ];
    }
}
