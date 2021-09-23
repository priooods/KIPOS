<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return redirect('/user/login');
        return view('halaman.home');
    }

    public function method_logout(){
        Auth::logout();
        return $this->HapusSemuaSession();
    }
}
