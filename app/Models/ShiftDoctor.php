<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftDoctor extends Model
{
    protected $table = 'doctor_shift_relation';
    protected $fillable = [
        'doctor_id',
        'shift_id'
        
       
       
    ];

   public function isInDepartment()
    {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }
}
