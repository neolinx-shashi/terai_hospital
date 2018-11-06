<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'room_name'=>'required|unique:room',
            'ward_id'=>'required',
            'floor'=>'required',
            'room_rate'=>'required',
            //'room_type'=>'required',
        ];
        return $rules;
    }
    public function messages()
    {
        return [
            'room_name.required'=>'The room name is required.',
            'room_type.required'=>'The room type is required.',
            'room_name.unique'=>'The room name must be unique.',
            'ward_id.required'=>'Ward must be selected',
            'floor.required'=>'Floor must be selected',
            'room_rate.required'=>'Room rate must be entered',
        ];
    }
}
