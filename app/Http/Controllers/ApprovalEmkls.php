<?php

namespace App\Http\Controllers;

use App\AllocationDetailEmkl;
use App\AlocationEmkl;
use App\Customer;
use App\RequestAlocationTruckDetail;
use App\TruckAllocationModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ApprovalEmkls extends Controller
{
    public function index($token, $user_id){
        if(!$token && $user_id)
            return $this->HapusSemuaSession();

        if(!Auth::user()->group_details)
             return $this->HapusSemuaSession();
        
        $result = AllocationDetailEmkl::paginate(10);
        return view('halaman.approval_emkl.index')->with('result', $result);
    }

     public function searching(Request $request){
        $result = AllocationDetailEmkl::where('transportir','like','%'. $request->transportir.'%')
            ->paginate(10);
        return view('halaman.approval_emkl.index')->with('result', $result);
    }

    public function index_approved($token, $header_id){
        if(!Auth::user()){
            if($token && $header_id){
                $url_mkl_email = '/mkl/detail/' . $token . '/' . $header_id;
                session()->put('url_mkl',$url_mkl_email);
            }
            return redirect('/user/login');
        }

        $detail = AllocationDetailEmkl::find(base64_decode($header_id));
        if($detail)
            session()->put('mkl_header', $detail);

        $dipakai = AlocationEmkl::where('t_request_allocation_truck_detail_id',base64_decode($header_id))
        ->where('status_request', 2)
        ->with(['mkl_dipakai' => function($a){
            $a->whereNotNull('m_internal_route_id')
            ->with(['detail_emkls' => function($c){
                    $c->with('customer_data');
                },'header_project' => function($h){
                    $h->with(['vesel_scehedule' => function($v) {
                        $v->with('vesel_data');
                    }]);
                },'trucks','commodity']);
        }])
        ->get();
        // return response()->json(['data' => $dipakai]);
        return view('halaman.approval_emkl.detail_emkl')->with('dipakai', $dipakai);
    }

    public function verifyed(Request $request){
        $allocation_emkl = AlocationEmkl::find($request->id);
        $allocation_emkl->update(['status_request' => 5]);

        $customer = User::where('id',$request->created_by)->with(['group_details' => function($a){
            $a->with('customers_detail');
        }])->first();

        $details = [
            'nama_tujuan' => $customer->group_details->customers_detail->name,
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

        $this->send_email(Auth::user()->group_details->customers_detail->name,
                Auth::user()->group_details->customers_detail->email ? 
                Auth::user()->group_details->customers_detail->email : 'belumterdaftar@gmail.com',
                $customer->group_details->customers_detail->name,
                $customer->group_details->customers_detail->email,'Verifikasi Permintaan', $details);
        if($allocation_emkl) {
            session()->forget('mkl_id');
            return $this->resSuccess('berhasil diverifikasi', $allocation_emkl);
        }
    }
    public function rejectEmails(Request $request){
        $allocation_emkl = AlocationEmkl::find($request->id);
        $allocation_emkl->update(['status_request' => 6]);

        $customer = User::where('id',$request->created_by)->with(['group_details' => function($a){
            $a->with('customers_detail');
        }])->first();


        $details = [
            'nama_tujuan' => $customer->group_details->customers_detail->name,
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

        $this->send_email(Auth::user()->group_details->customers_detail->name,
                Auth::user()->group_details->customers_detail->email ? 
                Auth::user()->group_details->customers_detail->email : 'belumterdaftar@gmail.com',
                $customer->group_details->customers_detail->name,
                $customer->group_details->customers_detail->email,'Verifikasi Permintaan', $details);
        
        if($allocation_emkl) {
            session()->forget('mkl_id');
            return $this->resSuccess('berhasil direjected !', $allocation_emkl);
        }
    }

    public function get_detail(){
        $list = AlocationEmkl::where('t_request_allocation_truck_detail_id',session()->get('mkl_header')->id)
        ->where('status_request', 2)
        ->orWhere('status_request', 5)->orWhere('status_request', 6)
        ->with('mobil','driver','route','consigne')->paginate(10);
        return response()->json([
            'error_code' => 0,
            'data' => session()->get('mkl_header'),
            'list' => $list
        ]);
    }
}
