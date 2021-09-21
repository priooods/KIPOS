<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TruckAllocationModel extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 't_truck_allocations';
    protected $fillable = ['m_trucks_id','m_internal_route_id','t_project_headers_id','t_request_allocation_truck_detail_id'];

    public function detail_emkls(){
        return $this->hasOne(RequestAlocationTruckDetail::class,'id','t_request_allocation_truck_detail_id');
    }
}
