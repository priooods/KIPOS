<?php

namespace App\Http\Controllers;

use App\AllocationDetailEmkl;
use App\AlocationEmkl;
use App\Customer;
use App\TruckAllocationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ApprovalGto extends Controller
{
    public function index($token){
        if(!session()->has('users'))
            return $this->HapusSemuaSession();

        if($token != Session::getId() || !$token)
            return $this->HapusSemuaSession();
        
        $result = AllocationDetailEmkl::paginate(10);
        session()->put('header_gto', $result);
        return view('halaman.approval_gto.index', compact('result'));
    }

    public function searching(Request $request){
        $result = AllocationDetailEmkl::where('project_no','like','%'. '13286'.'%')
        ->orWhere('transportir','like','%'. $request->ppj.'%')
        ->paginate(10);
        // 13286
        return view('halaman.approval_gto.index', compact('result'));
    }

    public function index_details($token,$id){
        if(!session('users'))
            return $this->HapusSemuaSession();
        $detail = AllocationDetailEmkl::find(base64_decode($id));
        if($detail) 
            session()->put('gto_detail', $detail);
        return view('halaman.approval_gto.detail_gto');
    }

    public function Approved(Request $request){
        $data = AlocationEmkl::find($request->id);
        if($data->status_request == 3 || $data->status_request == 4)
            return $this->resFailed('Data sudah di proses sebelumnya !');
        

        $data->update(['status_request' => 3]);
        $emkls = TruckAllocationModel::create($request->all());
        if(!$emkls) return $this->resFailed('Server gagal menerima request !');

        // return $this->resSuccess('data',session('users')->group_details->customers_detail->email);
        $customers = Customer::find(session('gto_detail')->emkl_id);
        $details = [
            'nama_tujuan' => $customers->name,
            'customers' => $customers->id,
            'gto_approved' => "Permintaan Truck anda telah kami Approved !"
        ];
        if(session('users')->group_details->customers_detail->email)
            $this->send_email(session('users')->group_details->customers_detail->name,session('users')->group_details->customers_detail->email,$customers->name, $customers->contact_email,'Permintaan GTO Di Approved', $details);
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
            $this->send_email(session('users')->group_details->customers_detail->name,
                    session('users')->group_details->customers_detail->email,$customers->name, $customers->contact_email,'Permintaan GTO Di Rejected', $details);
        
        return $this->resSuccess('Data berhasil di Rejected !', 'data');
    }

    public function get_detail(){
        $list = AlocationEmkl::where('t_request_allocation_truck_detail_id',session()->get('gto_detail')->id)
        ->where('status_request', 1)->orWhere('status_request', 3)->orWhere('status_request', 4)
        ->with('mobil','driver','route','consigne')->paginate(10);
        return response()->json([
            'error_code' => 0,
            'data' => session()->get('gto_detail'),
            'list' => $list
        ]);
    }
}
