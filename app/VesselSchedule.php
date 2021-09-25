<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VesselSchedule extends Model
{
    protected $primaryKey = 'id';
    protected $table = 't_vessel_schedules';
    protected $guarded = [];

    public function vesel_data(){
        return $this->hasOne(Vessel::class,'id','m_vessel_id');
    }
}
