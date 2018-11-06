<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    public $fillable = [
        'title',
        'parent_id',
        'price',
        'status',
    ];
    
    public function childs(){
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }
}
