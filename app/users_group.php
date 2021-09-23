<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class users_group extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'm_user_login_group_details';
    protected $guarded = [];
    

    public function customers_detail(){
        return $this->hasOne(Customer::class,'id','m_customer_id');
    }

}
