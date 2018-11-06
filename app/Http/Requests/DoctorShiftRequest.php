<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;
class DoctorShiftRequest extends FormRequest
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
    public function rules(\Illuminate\Http\Request $request)
    {
        $name = $request->get('start_time');
        $rules['day_id'] = 'required';

        foreach($name as $key => $val) {
            $rules['start_time.'.$key] = 'required';
            $rules['end_time.'.$key] = 'required';
            $rules['shift_type.'.$key] = 'required';
           
        }
        return $rules;
    }

     public function messages()
    {
        return [
            'day_id.required' => 'Day name is required',
            'start_time.*.required'=>'Start Time is required',
            'end_time.*.required'=>'End time is required',
            'shift_type.*.required'=>'Shift Type is required',
        ];
    }
}
