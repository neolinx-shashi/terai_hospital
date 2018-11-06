<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discount';

    protected $primaryKey = 'dis_id';

    protected $fillable = ['dis_percent', 'dis_type', 'cat_id'];
}
