<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeaderProject extends Model
{
    protected $primaryKey = 'id';
    protected $table = 't_project_headers';
    protected $guarded = [];

    public function commodity(){
        return $this->hasOne(Commodity::class,'t_booking_id','t_booking_id');
    }
    
}
