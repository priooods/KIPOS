<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'm_trucks';
    protected $fillable = ['nopol','exp_date'];

}
