<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeaderProject extends Model
{
    protected $primaryKey = 'id';
    protected $table = 't_project_headers';
    protected $guarded = [];

    public function commodity(){
        return $this->hasOne(CommodityBooking::class,'t_booking_id','t_booking_id');
    }

    public function vesel_scehedule(){
        return $this->hasOne(VesselSchedule::class,'id','t_vessel_schedule_id');
    }
    
}
