<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $primaryKey = 'id';
    protected $table = 't_commodity_bookings';
    protected $guarded = [];
    
}
