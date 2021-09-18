<?php

namespace App\Http\Controllers;

use App\AllocationDetailEmkl;
use App\AlocationEmkl;
use App\Customer;
use App\Driver;
use App\DRoutes;
use App\Truck;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

class TruckAllocation extends Controller
{
    public function index(){
        if(!session()->has('users'))
            return $this->HapusSemuaSession();

        
        $users = session('users');
        $result = AllocationDetailEmkl::where('emkl_id',$users->group_details->m_customer_id)
            ->paginate(10);

        session()->put('header', $result);
        return view('halaman.truckallocation.index',compact('result'));
    }

    public function allocation_detail($id){
        $detail = AllocationDetailEmkl::find(base64_decode($id));
        $list = AlocationEmkl::where('t_request_allocation_truck_detail_id',$detail->id)->with('mobil','driver','route','consigne')->paginate(5);
        // return $list;
        session()->put('allocation_detail', $detail);
        return view('halaman.truckallocation.detail',['detail' => $detail, 'list' => $list]);
    }

    public function method_truck(Request $request){
        $cari = Truck::where('nopol','like','%'.$request->nopol.'%')->paginate(6);
        return $cari->getCollection();
    }
    public function method_consignee(Request $request){
        $cari = Customer::where('code','like','%'.$request->code.'%')->paginate(6);
        return $cari->getCollection();
    }
    public function method_driver(Request $request){
        $cari = Driver::where('name','like','%'.$request->name.'%')->paginate(6);
        return $cari->getCollection();
    }
    public function method_routes(Request $request){
        $cari = DRoutes::where('description','like','%'.$request->description.'%')->paginate(6);
        return $cari->getCollection();
    }

    public function delete_emkls(Request $request){
        $emkl = AlocationEmkl::find($request->id);
        $emkl->delete();
        $id = base64_encode(session()->get('allocation_detail')->id);
        return redirect('/allocation/'. $id);
    }

    public function send_request(){
        // $request['id'] = session()->get('allocation_detail')->id;
        $alocation = AlocationEmkl::where('t_request_allocation_truck_detail_id',session()->get('allocation_detail')->id)->get();
        return $alocation;
    }

    public function save_emkls(Request $request){
        // $this->validate($request, [
        //     'm_trucks_id' => 'required|string',
        //     'm_drivers_id' => 'required|string',
        //     'ritase' => 'required|int',
        //     'active_start' => 'required|string',
        //     'active_end' => 'required|string',
        //     'm_consignee_id' => 'required|string',
        //     'm_route_id' => 'required|string',
        //     'destination' => 'required'
        // ]);

        $request['created_by'] = session()->get('users')->id;
        $request['created'] = new DateTime();
        
        $request['t_request_allocation_truck_detail_id'] = session()->get('allocation_detail')->id;
        $request['t_project_headers_id'] = session()->get('allocation_detail')->t_project_header_id;

        return $request;
        // $save = AlocationEmkl::create($request->all());

        // $id = base64_encode(session()->get('allocation_detail')->id);
        // return redirect('/allocation/'. $id);
    }
    
}
