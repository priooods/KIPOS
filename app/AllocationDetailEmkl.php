<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AllocationDetailEmkl extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'view_t_request_allocations_detail_emkls';
    protected $fillable = ['project_no','vessel','truck_qty','consignee','emkl_id','commodity','truck_type','transportir'];
}
