<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function RealtimeDates(){
        $dates = Date('D-M-Y');
        return $dates;
    }

    public function HapusSemuaSession(){
        session()->flush();
        return redirect('/user/login');
    }

    // public function 

    public function resPage($data){
        return response()->json([
            'error_code' => 0,
            'data' => $data->getCollection(),
            'pages' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage()
                ]
            ], 200, []);
    }
}
