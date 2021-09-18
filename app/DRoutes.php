<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DRoutes extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'm_route';
    protected $fillable = ['code','description','m_destination_id'];
}
