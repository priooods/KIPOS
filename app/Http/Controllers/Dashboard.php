<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{

    public function index(){
        if(!session()->has('users'))
            return redirect('/survey');
            // return $this->HapusSemuaSession();

        return view('halaman.home');
    }

    public function method_logout(){
        return $this->HapusSemuaSession();
    }
}
