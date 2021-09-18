<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'm_drivers';
    protected $fillable = ['code','name','address'];

}
