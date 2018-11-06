<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'room';
    protected $fillable = [
        'room_name',
        'room_type',
        'ward_id',
        'floor',
        'room_rate',
    ];
    public function isOfWard()
    {
        return $this->belongsTo('App\Models\Ward', 'ward_id');
    }
}
