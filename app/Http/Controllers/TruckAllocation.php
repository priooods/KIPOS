<?php

namespace App\Http\Controllers;

use App\AllocationDetailEmkl;
use App\AlocationEmkl;
use App\Configuration;
use App\Customer;
use App\Driver;
use App\DRoutes;
use App\Mail\MailGTO;
use App\Truck;
use App\TruckAllocationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

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

    public function index_details($id){
        $detail = AllocationDetailEmkl::find(base64_decode($id));
        if($detail) 
            session()->put('allocation_detail', $detail);
        return view('halaman.truckallocation.detail');
    }

    public function get_detail(){
        $id = base64_encode(session()->get('allocation_detail')->id);
        $detail = AllocationDetailEmkl::find(base64_decode($id));
        $list = AlocationEmkl::where('t_request_allocation_truck_detail_id',$detail->id)->orderBy('id')->with('mobil','driver','route','consigne')->paginate(10);
        return response()->json([
            'error_code' => 0,
            'data' => $detail,
            'list' => $list
        ]);
    }

    // group 2 => truck_alocation mkl

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

    public function send_request(){
        $emkls = AlocationEmkl::where('t_request_allocation_truck_detail_id',session()->get('allocation_detail')->id)->get();

        foreach ($emkls as $item) {
            $codes = base64_encode(session('allocation_detail')->id);
            $truckallocation = TruckAllocationModel::
                where('m_trucks_id', $item->m_trucks_id)
                ->whereNotNull('m_internal_route_id')
                ->orderBy('id','desc')->take(1)
                ->count();
            $emkl = AlocationEmkl::where('id',$item->id)->with('mobil','driver','route','consigne')->first();
            if(!$truckallocation){
                $emkl->update(['status_request' => 1]);
                $users = Configuration::where('parameter','=','email_approval_alokasi_truck')->first();
                $details = [
                    'desc' => '',
                    'nama_tujuan' => $users->value1,
                    'nopol' => $emkl->mobil->nopol,
                    'dari' => session('users')->group_details->customers_detail->name,
                    'link' => Session::getId() . '/' . $codes,
                    'table' => [
                        'Polisi' => $emkl->mobil->nopol,
                        'Driver' => $emkl->driver->name,
                        'Ritase' => $emkl->ritase,
                        'Active_date' => $emkl->active_start,
                        'End_date' => $emkl->active_end,
                        'consigne' => $emkl->consigne->name,
                        'routes' => $emkl->route->description,
                    ]
                ];

                if(session('users')->group_details->customers_detail->email)
                    $this->send_email(session('users')->group_details->customers_detail->name,
                    session('users')->group_details->customers_detail->email,
                    $users->value1, $users->value1,'Permintaan GTO', $details);
            }
            else
                $emkl->update(['status_request' => 2]);
        }
        $check_email = session('users')->group_details->customers_detail->email;
        return $this->resEmails('Permintaan berhasil dikirim !', $check_email ? 0 : 1);
    }

    public function sendEmails(Request $request){
        $data = TruckAllocationModel::where('m_trucks_id', $request->m_trucks_id)
        ->with(['detail_emkls' => function($q) {
            $q->with('customer_data');
        }])->first();

        $emkl = AlocationEmkl::where('id',$request->id)->with('mobil','driver','route','consigne')->first();
        session()->put('mkl_id',$request->id);
        $details = [
            'nama_tujuan' => $data->detail_emkls->customer_data->name,
            'nopol' => $emkl->mobil->nopol,
            'dari' => session('users')->group_details->customers_detail->name,
            'link_customer' => Session::getId() . '/' . base64_encode($data->detail_emkls->customer_data->id) . '/' . base64_encode($emkl->id),
            'table' => [
                'Polisi' => $emkl->mobil->nopol,
                'Driver' => $emkl->driver->name,
                'Ritase' => $emkl->ritase,
                'Active_date' => $emkl->active_start,
                'End_date' => $emkl->active_end,
                'consigne' => $emkl->consigne->name,
                'routes' => $emkl->route->description,
            ],
        ];
        $this->send_email(session('users')->group_details->customers_detail->name,
                session('users')->group_details->customers_detail->email ? 
                session('users')->group_details->customers_detail->email : "belumterdaftar@example.com",
                $data->detail_emkls->customer_data->name, $data->detail_emkls->customer_data->email,'Permintaan GTO', $details);
        return $this->resSuccess('e-mail berhasil dikirim !', $emkl);
    }

    public function save_emkls(Request $request){
        $request['created_by'] = session()->get('users')->id;
        
        $request['t_request_allocation_truck_detail_id'] = session()->get('allocation_detail')->id;
        $request['m_consignee_id'] = session()->get('allocation_detail')->consignee_id;
        $request['t_project_headers_id'] = session()->get('allocation_detail')->t_project_header_id;

        $allocations = AlocationEmkl::where('t_project_headers_id',$request->t_project_headers_id)
            ->where('m_trucks_id',$request->m_trucks_id)->count();
        if(!$allocations){
            $save = AlocationEmkl::create($request->all());
            return $this->get_detail();
        }
        return $this->resFailed('Informasi truck ini sudah ditambahkan pada ppj ' . session('allocation_detail')->project_no);
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
