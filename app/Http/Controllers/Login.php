<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class Login extends Controller
{

    public function __construct()
    {
        $this->middleware('web', ['except' => ['method_login','index']]);
    }

    public function index(){
        if(Auth::check())
            Auth::logout();
        return view('login');
    }

    public function method_login(Request $request){

        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        

        $credentials['password'] = 'appcoregwnih'.$request->password;
        if(!Auth::attempt($credentials)){
            return redirect('/user/login')->with('failure','Account anda tidak ditemukan !');
        }

        if(!Auth::user()->group_details)
            return redirect('/user/login')->with('failure','Account anda tidak ditemukan !');

        // return Auth::user();

        if(session()->get('url_gto'))
            return redirect(session()->get('url_gto'));

        if(Auth::user()->group_id == 2)
            return redirect('/mkl/' . Session::getId() . '/' . base64_encode(Auth::user()->id));
        if(Auth::user()->group_id == 33)
            return redirect('/gto/' . Session::getId());
        return redirect('/allocation');
    } 
}
