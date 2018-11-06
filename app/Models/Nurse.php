<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'age',
        'gender',
        'contact_no',
        'emergency_contact',
        'nmc_no',
        'address',
        'email',
        'image_name',
        'nurse_description',
        'designation',
        'nurse_code',
        'department_id',
        'status',
    ];
}
