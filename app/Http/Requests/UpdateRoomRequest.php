<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
            'room_name'=>'required',
            'ward_id'=>'required',
            'floor'=>'required',
            'room_rate'=>'required',
            
        ];
        return $rules;
    }
    public function messages()
    {
        return [
            'room_name.required'=>'The room name is required.',
            'room_type.required'=>'The room type is required.',
            'ward_id.required'=>'Ward must be selected',
            'floor.required'=>'Floor must be selected',
            'room_rate.required'=>'Room rate must be entered',
        ];
    }
}
