<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommodityBooking extends Model
{
    protected $primaryKey = 'id';
    protected $table = 't_commodity_bookings';
    protected $guarded = [];
}
