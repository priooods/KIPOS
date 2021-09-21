<?php

namespace App\Http\Controllers;

use App\AllocationDetailEmkl;
use App\AlocationEmkl;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ApprovalEmkls extends Controller
{
    public function index($token, $id, $emkl){

        $urls = 'emkls/' . $token . '/' . $id . '/' . $emkl;
        echo($urls);
        if(!session()->has('users') && $token != Session::getId()){
            session()->put('urls_emkls',$urls);
            return $this->HapusSemuaSession();
        }
        
        $customer = Customer::find(base64_decode($id));
        session()->put('customer', $customer);

        $result = AllocationDetailEmkl::where('emkl_id' , base64_decode($id))->paginate(10);
        // return $result;
        return view('halaman.approval_emkl.index', compact('result'));
    }

    public function verifyed(Request $request){
        $allocation_emkl = AlocationEmkl::find(session('mkl_id'));
        // return $this->resSuccess('jkjk', $allocation_emkl);
        // $allocation_emkl->update(['status_request' => 5]);

        $customer = Customer::find(session('customer')->id);
        return $this->resSuccess('s', $customer);
        $details = [
            'nama_tujuan' => $customer->name,
            'pesan' => 'telah kami verifikasi',
            'table_emkl' => [
                'Project_No' => $request->project_no,
                'Vessel' => $request->vessel,
                'Consignee' => $request->consignee,
                'Truck_Qty' => $request->truck_qty,
                'Commodity' => $request->commodity,
                'Truck_Type' => $request->truck_type,
                'Transportir' => $request->transportir,
            ]
        ];

        // informasi detail dari EMKL = tertntu.
        // mkl_id
        // atas nama yang ngirim ,, mohon ijin untuk menggunakan truck dengan nopol ( ini), namun truck ini masih digunakan dalam proyek
        //  dibawah baru table yang sekarang 

        $this->send_email(session('users')->group_details->customers_detail->name,
                session('users')->group_details->customers_detail->email ? 
                session('users')->group_details->customers_detail->email : 'belumterdaftar@gmail.com',
                $customer->name, $customer->email,'Verifikasi Permintaan', $details);
        // if($allocation_emkl) {
        //     session()->forget('mkl_id');
        //     return $this->resSuccess('berhasil diverifikasi', $allocation_emkl);
        // }
        session()->forget('mkl_id');
        return $this->resSuccess('berhasil diverifikasi', $allocation_emkl);
    }
    public function rejectEmails(Request $request){
        $allocation_emkl = AlocationEmkl::find(session('mkl_id'));
        $allocation_emkl->update(['status_request' => 6]);

        $customer = Customer::find(session('customer')->id);
        $details = [
            'nama_tujuan' => $customer->name,
            'pesan' => 'telah kami Rejected',
            'table_emkl' => [
                'Project_No' => $request->project_no,
                'Vessel' => $request->vessel,
                'Consignee' => $request->consignee,
                'Truck_Qty' => $request->truck_qty,
                'Commodity' => $request->commodity,
                'Truck_Type' => $request->truck_type,
                'Transportir' => $request->transportir,
            ]
        ];

        $this->send_email(session('users')->group_details->customers_detail->name,
                session('users')->group_details->customers_detail->email,$customer->name, $customer->email,'Rejected Permintaan', $details);
        if($allocation_emkl) {
            session()->forget('mkl_id');
            return $this->resSuccess('berhasil direjected !', $allocation_emkl);
        }
    }
}