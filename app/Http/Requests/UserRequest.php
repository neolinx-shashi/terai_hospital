<?php
/**
 * Created by PhpStorm.
 * User: ym-jenish
 * Date: 2/2/16
 * Time: 11:17 AM
 */

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {


        $rules = [

            'fullname' => 'required',
            'email' => 'required|unique:users|max:255',
            'contact_no' => 'required|min:9|alpha_dash',
            'gender' => 'required',
            'address' => 'required',
            'user_post' => 'required',
            'user_type_id' => 'required',
            'password' => 'required|min:6'
            // 'userimage_name' => 'required|mimes:jpeg,bmp,png'

        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'fullname.required' => 'FullName is required',
            'email.required' => 'Username is required',
            'email.unique'=>'This username has already been taken',
            'contact_no.required' => 'Contact Number is required',
            'gender.required' => 'Please Choose Your Gender',
            'address.required' => 'Address is required',
            'user_post.required' => 'User Designation is required',
            'user_type_id.required' => 'User Type must be selected',
            'password.required' => 'Password a required field.',
            // 'userimage_name.required' => 'Image is Required.',
            // 'userimage_name.mimes'=>'Image is not a valid type.',
            // 'userimage_name.dimensions'=>'File is small',
            'password.min:6'=>'Password must be minimum 6 character',
            'contact_no.min:9'=>'Contact Number must be minimum 9 characters in length',
            'contact_no.alpha_dash'=>'Only numeric and -  value are allowed'


        ];
    }


}