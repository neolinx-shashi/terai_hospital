<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestDetail extends Model
{
    protected $fillable = [
        'bid',
        'test_id',
        'test_price',
        'test_discount',
        'qty',
        'rate'
    ];
    protected $table = 'test_detail';

    public function belongsToCategory()
    {
        return $this->belongsTo('App\Models\Category', 'test_id');
    }
}
