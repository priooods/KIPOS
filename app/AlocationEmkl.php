<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlocationEmkl extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 't_truck_allocation_emkls';
    protected $guarded = [];

    public function mkl_dipakai(){
        return $this->hasOne(TruckAllocationModel::class,'m_trucks_id','m_trucks_id');
    }

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
