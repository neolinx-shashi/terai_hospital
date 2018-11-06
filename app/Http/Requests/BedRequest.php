<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BedRequest extends FormRequest
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
        $rules = [
            'bed_name'=>'required',
            'ward_id'=>'required',
            'room_id'=>'required',
        ];
        return $rules;
    }
    public function messages()
    {
        return [
            'bed_name.required'=>'The bed name is required.',
            'ward_id'=>'Ward must be selected',
            'room_id'=>'Room must be selected',
        ];
        return $rules;
    }
}