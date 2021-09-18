<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class users_group extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'm_user_login_group_details';
    protected $fillable = ['m_user_id','m_customer_id','m_employee_id'];

}
