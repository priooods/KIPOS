<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Login extends Controller
{
    public function index(){
        return view('login');
    }

    public function method_login(Request $request){

        $this->validate($request,[
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $users = User::where('username', $request->input('username'))
            ->where('password',sha1('appcoregwnih'.$request->input('password')))
            ->with(['group_details' => function($a){
                $a->with('customers_detail');
            }])->first();


        if(!$users)
            return redirect('/')->with('failure','Account anda tidak ditemukan !');

        $users->group_details;
        $request->session()->put('users',$users);
        return redirect('/');
    } 
}
