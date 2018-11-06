<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
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
            'name' => 'required',
            'contact' => 'required|numeric',
            'type' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Contact Name is Required!',
            'name.unique' => 'Contact Name must be Unique!',
            'name.min' => 'Contact Name must be of at least 3 characters!',
            'contact.required' => 'Contact Number is Required!',
            'contact.numeric' => 'Contact Number must be Numeric!',
            'type.required' => 'Contact Type is Required!',
        ];
    }
}
