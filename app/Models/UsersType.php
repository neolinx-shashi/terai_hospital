<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class UsersType extends Model {


    protected $table='users_type';

    protected $fillable = ['type_label',
                            'type_name',
                            'status'];

    


}