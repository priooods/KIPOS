<?php

namespace App\Http\Controllers;

use App\AllocationDetailEmkl;
use App\AlocationEmkl;
use App\Customer;
use App\TruckAllocationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ApprovalGto extends Controller
{
    public function index($token){
        if(!Auth::user())
            return $this->HapusSemuaSession();

        if($token != Session::getId() || !$token)
            return $this->HapusSemuaSession();
        
        $result = AllocationDetailEmkl::paginate(10);
        session()->put('header_gto', $result);
        return view('halaman.approval_gto.index')->with('result', $result);
    }

    public function searching(Request $request){
        $result = AllocationDetailEmkl::where('project_no','like','%'. '13286'.'%')
            ->orWhere('transportir','like','%'. $request->ppj.'%')
            ->paginate(10);
        return view('halaman.approval_gto.index', compact('result'));
    }

    public function index_details($token,$header_id){
        //Check user udah login belum & Check user access approval GTO
        if(!Auth::user()){
            //Check url dari email
            if($token && $header_id){
                $url_gto_email = '/approval/gto/' . $token . '/' . $header_id;
                session()->put('url_gto',$url_gto_email);
            }
            return redirect('/user/login');
        }
        
        $detail = AllocationDetailEmkl::find(base64_decode($header_id));
        if($detail)
            session()->put('gto_detail', $detail);
        return view('halaman.approval_gto.detail_gto');
    }

    public function Approved(Request $request){
        $customers = Customer::find(session('gto_detail')->emkl_id);

        $data = AlocationEmkl::find($request->id);

        if($data->status_request == 3 && $data->status_request == 4)
            return $this->resFailed('Data sudah di proses sebelumnya !');

        $data->update(['status_request' => 3]);

        $emkls = TruckAllocationModel::create([
            'active_end' => $request->active_end,
            'active_start' => $request->active_start,
            'destination' => $request->destination,
            'm_consignee_id' => $request->m_consignee_id,
            'm_drivers_id' => $request->m_drivers_id,
            'm_route_id' => $request->m_route_id,
            'm_trucks_id' => $request->m_trucks_id,
            'ritase' => $request->ritase,
            't_project_headers_id' => $request->t_project_headers_id,
            't_request_allocation_truck_detail_id' => $request->t_request_allocation_truck_detail_id,
        ]);
        if(!$emkls) 
            return $this->resFailed('Server gagal menerima request !');

        $details = [
            'nama_tujuan' => $customers->name,
            'customers' => $customers->id,
            'gto_approved' => "Permintaan Truck anda telah kami Approved !"
        ];
        if(Auth::user()->group_details->customers_detail->email)
            $this->send_email(Auth::user()->group_details->customers_detail->name,Auth::user()->group_details->customers_detail->email,$customers->name, $customers->email,'Permintaan GTO Di Approved' . ' ( ' . date('d-m-Y') . ' )', $details);
        return $this->resSuccess('Data berhasil di Approved !', $customers);
    }

    public function Rejected(Request $request){
        $data = AlocationEmkl::find($request->id);
        $data->update(['status_request' => 4]);
        $customers = Customer::find(session('gto_detail')->emkl_id);
        $details = [
            'nama_tujuan' => $customers->name,
            'customers' => $customers->id,
            'gto_approved' => "Permintaan GTO anda di Rejected !"
        ];
        if($customers->email)
            $this->send_email(Auth::user()->group_details->customers_detail->name,
                    Auth::user()->group_details->customers_detail->email,$customers->name, $customers->email,'Permintaan GTO Di Rejected', $details);
        
        return $this->resSuccess('Data berhasil di Rejected !', 'data');
    }

    public function get_detail(){
        $list = AlocationEmkl::where('t_request_allocation_truck_detail_id',session()->get('gto_detail')->id)
        ->where('status_request', 1)
        // ->orWhere('status_request', 3)->orWhere('status_request', 4)
        ->with('mobil','driver','route','consigne')->paginate(10);
        return response()->json([
            'error_code' => 0,
            'data' => session()->get('gto_detail'),
            'list' => $list
        ]);
    }
}
