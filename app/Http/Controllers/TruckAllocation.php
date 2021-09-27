<?php

namespace App\Http\Controllers;

use App\AllocationDetailEmkl;
use App\AlocationEmkl;
use App\Configuration;
use App\Customer;
use App\Driver;
use App\DRoutes;
use App\HeaderProject;
use App\Mail\MailGTO;
use App\RequestAlocationTruckDetail;
use App\Truck;
use App\TruckAllocationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class TruckAllocation extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    public function index(){
        $result = AllocationDetailEmkl::where('emkl_id',Auth::user()->group_details->m_customer_id)
            ->paginate(10);
        return view('halaman.truckallocation.index')->with('result', $result);
    }

    public function index_details($id){
        $detail = AllocationDetailEmkl::find(base64_decode($id));
        session()->put('detail', $detail);
        return view('halaman.truckallocation.detail')->with('detail', $detail);
    }

    public function get_detail(){
        $detail = AllocationDetailEmkl::find(session('detail')->id);
        $list = AlocationEmkl::where('t_request_allocation_truck_detail_id',$detail->id)->orderBy('id')->with('mobil','driver','route','consigne')->paginate(10);
        return response()->json([
            'error_code' => 0,
            'data' => $detail,
            'list' => $list,
        ]);
    }

    // group 2 => truck_alocation mkl

    public function method_truck(Request $request){
        $cari = Truck::orderBy('nopol')->where('nopol','like','%'.$request->nopol.'%')->paginate(10);
        return $cari->getCollection();
    }

    public function method_consignee(Request $request){
        $cari = Customer::orderBy('code')->where('code','like','%'.$request->code.'%')->paginate(6);
        return $cari->getCollection();
    }

    public function method_driver(Request $request){
        $cari = Driver::orderBy('name')->where('name','like','%'.$request->name.'%')->paginate(6);
        return $cari->getCollection();
    }
    
    public function method_routes(Request $request){
        $cari = DRoutes::orderBy('description')->where('description','like','%'.$request->description.'%')->paginate(6);
        return $cari->getCollection();
    }


    public function send_request(){
        $emkls = AlocationEmkl::where('t_request_allocation_truck_detail_id',session('detail')->id)->get();

        foreach ($emkls as $item) {
            $header_id = base64_encode(session('detail')->id);
            $truckallocation = TruckAllocationModel::where('m_trucks_id', $item->m_trucks_id)
                ->whereNotNull('m_internal_route_id')
                ->orderBy('id','desc')->take(1)
                ->count();
            $emkl = AlocationEmkl::where('id',$item->id)->with('mobil','driver','route','consigne')->first();
            if(!$truckallocation){
                $emkl->update(['status_request' => 1]);
                $users = Configuration::where('parameter','=','email_approval_alokasi_truck')->first();
                $details = [
                    'nama_tujuan' => $users->value1,
                    'nopol' => $emkl->mobil->nopol,
                    'dari' => Auth::user()->group_details->customers_detail->name,
                    'link' => '/gto/detail/' . session()->getId() . '/' . $header_id,
                    'table' => [
                        'Polisi' => $emkl->mobil->nopol,
                        'Driver' => $emkl->driver ? $emkl->driver->name : 'tidak terdaftar',
                        'Active_date' => $emkl->active_start,
                        'End_date' => $emkl->active_end,
                        'consigne' => $emkl->consigne->name,
                        'routes' => $emkl->route->description,
                    ]
                ];

                if(Auth::user()->group_details->customers_detail->email && $item->status_request == 0)
                    $this->send_email(Auth::user()->group_details->customers_detail->name,
                        Auth::user()->group_details->customers_detail->email,
                        $users->value1, $users->value1,'Permintaan GTO' . ' ( ' . date('d-m-Y') . ' )', $details);
            }
            else
                $emkl->update(['status_request' => 2]);
        }
        $check_email = Auth::user()->group_details->customers_detail->email;
        return $this->resEmails('Permintaan berhasil dikirim !', $check_email ? 0 : 1);
    }

    public function sendEmails(Request $request){

        $tujuan = TruckAllocationModel::where('m_trucks_id',$request->m_trucks_id)
            ->whereNotNull('m_internal_route_id')
            ->with(['detail_emkls' => function($s){
                $s->with('customer_data');
            }])
            ->first();

        $emkl = AlocationEmkl::where('id',$request->id)->with('mobil','driver','route','consigne')->first();
        session()->put('mkl_id',$request->id);
        $details = [
            'nama_tujuan' => $tujuan->detail_emkls->customer_data ? $tujuan->detail_emkls->customer_data->name : 'Failure Mail',
            'nopol' => $emkl->mobil->nopol,
            'dari' => Auth::user()->group_details->customers_detail ? Auth::user()->group_details->customers_detail->name : Auth::user()->realname,
            'link_mkl' => '/mkl/detail/' . session()->getId() . '/' . base64_encode(session('detail')->id),
            'table' => [
                'Polisi' => $emkl->mobil->nopol,
                'Driver' => $emkl->driver ? $emkl->driver->name : 'tidak terdaftar',
                'Ritase' => $emkl->ritase ? $emkl->ritase : '0',
                'Active_date' => $emkl->active_start,
                'End_date' => $emkl->active_end,
                'consigne' => $emkl->consigne->name,
                'routes' => $emkl->route->description,
            ],
        ];
        $check_email = Auth::user()->group_details->customers_detail->email;
        $check_penerima = $tujuan->detail_emkls->customer_data;
        if($check_email && $check_penerima){
            $this->send_email(Auth::user()->group_details->customers_detail->name,Auth::user()->group_details->customers_detail->email,
                $tujuan->detail_emkls->customer_data->name,$tujuan->detail_emkls->customer_data->email,'Permintaan MKL'. ' ( ' . date('d-m-Y') . ' )', $details);
            return $this->resEmails('e-mail berhasil dikirim !', $check_email ? 0 : 1);
        }
        return $this->resEmails('E-mail tidak terkirim karena email anda tidak terdaftar ! Hubungi pemasaran untuk menambahkan email anda', $check_email ? 1 : 0);
    }

    public function save_emkls(Request $request){

        $commodity = HeaderProject::where('id',$request->session()->get('detail')->t_project_header_id)
            ->with('commodity')->first();
        $request['created_by'] = Auth::user()->id;
        $request['m_commodities_id'] = $commodity->commodity->m_commodity_name_id;
        $request['t_request_allocation_truck_detail_id'] = session()->get('detail')->id;
        $request['m_consignee_id'] = session()->get('detail')->consignee_id;
        $request['t_project_headers_id'] = session()->get('detail')->t_project_header_id;

        $allocations = AlocationEmkl::where('t_project_headers_id',$request->t_project_headers_id)
            ->where('m_trucks_id',$request->m_trucks_id)->count();
        if(!$allocations){
            $save = AlocationEmkl::create($request->all());
            return $this->get_detail();
        }
        return $this->resFailed('Informasi truck ini sudah ditambahkan pada ppj ' . session('detail')->project_no);
    }

    public function delete_emkls(Request $request){
        $emkl = AlocationEmkl::find($request->id);

        if($emkl->status_request != 0)
            return $this->resFailed('Data gagal dihapus !');

        $emkl->delete();
        if($emkl)
            return $this->get_detail();
        return $this->resFailed('Data gagal dihapus !');
    }
    
}
