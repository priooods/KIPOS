<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'm_commodities';
    protected $guarded = [];
    
}
