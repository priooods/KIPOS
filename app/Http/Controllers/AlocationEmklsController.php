<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlocationEmklsController extends Controller
{
    public function index(Request $request){
        if(!session()->has('users'))
            return $this->HapusSemuaSession();

        
        // $users = session('users');
        // $result = AllocationDetailEmkl::where('emkl_id',$users->group_details->m_customer_id)
        //     ->paginate(10);
        
        // session()->put('header', $result);
        // return view('halaman.truckallocation.index',compact('result'));
    }

    public function allocation_detail(Request $request){
        // $detail = AllocationDetailEmkl::find(base64_decode($request->id));
        // session()->put('allocation_detail', $detail);
        // return view('halaman.truckallocation.detail',compact('detail'));
    }

    public function method_truck(Request $request){
        // $cari = Truck::where('nopol','like','%'.$request->nopol.'%')->paginate(10);
        // return $cari->getCollection();
    }
    // public function method_consignee(Request $request){
    //     $cari = Customer::where('code','like','%'.$request->code.'%')->paginate(10);
    //     return $cari->getCollection();
    // }
    // public function method_driver(Request $request){
    //     $cari = Driver::where('name','like','%'.$request->name.'%')->paginate(10);
    //     return $cari->getCollection();
    // }
    // public function method_routes(Request $request){
    //     $cari = DRoutes::where('description','like','%'.$request->description.'%')->paginate(10);
    //     return $cari->getCollection();
    // }
}
