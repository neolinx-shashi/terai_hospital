<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCharge extends Model
{
    protected $fillable = [
        'name',
        'percent',
        'status',
    ];
}
