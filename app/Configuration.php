<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'm_configurations';
    protected $fillable = ['value1','parameter'];
}
