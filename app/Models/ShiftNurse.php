<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftNurse extends Model
{
    protected $table = 'nurse_shift_relation';
    protected $fillable = [
        'nurse_id',
        'shift_id'



    ];

    /*public function isInDepartment()
    {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }*/
}
