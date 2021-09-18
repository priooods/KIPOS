<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'm_customers';
    protected $fillable = ['user_id','prefix_code','code','name','code_ifs'];

}
