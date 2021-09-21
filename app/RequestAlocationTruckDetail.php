<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestAlocationTruckDetail extends Model
{
    protected $primaryKey = 'id';
    protected $table = 't_request_allocation_truck_details';
    protected $fillable = ['emkl_id'];

    public function customer_data(){
        return $this->hasOne(Customer::class,'id','emkl_id');
    }
}
