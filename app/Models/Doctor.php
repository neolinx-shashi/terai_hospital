<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors';
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'age',
        'gender',
        'department_id',
        'contact_no',
        'nmc_no',
        'address',
        'email',
        'normal_fee',
        'emergency_fee',
        'image_name',
        'doctor_description',
        'doctor_code',
        'status',
        'designation',
        'emergency_contact'
    ];

   public function isInDepartment()
    {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }


}
