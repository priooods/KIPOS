<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vessel extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'm_vessels';
    protected $guarded = [];
}
