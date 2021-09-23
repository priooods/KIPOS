<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TruckAllocationModel extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 't_truck_allocations';
    protected $guarded = [];

    public function detail_emkls(){
        return $this->hasOne(RequestAlocationTruckDetail::class,'id','t_request_allocation_truck_detail_id');
    }

    public function detail_mkl(){
        return $this->hasMany(RequestAlocationTruckDetail::class,'id','t_request_allocation_truck_detail_id');
    }
}
