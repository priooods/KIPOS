<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlocationEmkl extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 't_truck_allocation_emkls';
    protected $fillable = ['t_project_headers_id','destination','updated_at','t_request_allocation_truck_detail_id','m_trucks_id'
        ,'m_drivers_id','ritase','active_start','active_end','m_consignee_id','m_route_id',
        'created_by','created','status_request'];

    public function mobil(){
        return $this->hasOne(Truck::class,'id','m_trucks_id');
    }

    public function consigne(){
        return $this->hasOne(Customer::class,'id','m_consignee_id');
    }

    public function driver(){
        return $this->hasOne(Driver::class,'id','m_drivers_id');
    }
    public function route(){
        return $this->hasOne(DRoutes::class,'id','m_route_id');
    }
}
