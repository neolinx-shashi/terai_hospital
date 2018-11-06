<?php
/**
 * Created by PhpStorm.
 * User: ym-jenish
 * Date: 2/2/16
 * Time: 11:17 AM
 */

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ConsultingFeeRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {


        $rules = [

            'normal_hours' => 'required',

        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'normal_hours.required' => 'Normal Hour Fee is Required',

        ];
    }


}