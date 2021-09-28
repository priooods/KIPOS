<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index($token){
        $data['informations'] = \DB::select("SELECT 
        t_project_headers.id,
        t_project_headers.project_no AS no_ppj,
        GROUP_CONCAT(m_service_codes.name ORDER BY m_service_codes.name) AS nama_jasa,
        m_customers.name AS nama_customer,
        m_vessels.name as vessel_name
      FROM 
       (((((t_customer_rating_headers JOIN t_project_details ON t_customer_rating_headers.t_project_header_id = t_project_details.t_project_header_id)
       JOIN t_project_headers ON t_project_details.t_project_header_id = t_project_headers.id)
       JOIN m_customers ON t_customer_rating_headers.m_customer_id = m_customers.id)
       JOIN m_service_codes ON t_project_details.m_service_code_id = m_service_codes.id)
       LEFT JOIN t_vessel_schedules ON t_project_headers.t_vessel_schedule_id = t_vessel_schedules.id)
       LEFT JOIN m_vessels ON m_vessels.id = t_vessel_schedules.m_vessel_id
      WHERE 
       t_customer_rating_headers.token_no = '$token'
       AND t_customer_rating_headers.token_status = '1'
       AND t_project_details.flag_served = 'Y'
       AND t_project_details.status_close = 'Y';");
            // dd($data);
            // dd($data['informations'][0]->id);
            if (!isset($data['informations'][0]->id)) {
               return "Terima kasih telah memberikan penilaian." ;
            }

        $data['list_item'] = \DB::select("select * from m_customer_rating_items where item_status = 1 ");

            // dd($data);
        return view('halaman.survey.survey_index', $data);
    }


    public function update(Request $request, $id)
    {
        // dd($request->all());
       
        $header = \App\TCustomerRatingHeader::where('t_project_header_id', $id)->first();
        // dd($header);
        $header->update([
            'overall_rating'=> $request->overall_rating,
            'customer_comment'=> $request->coment,
            'token_status'=> 0,
        ]);

        if($request->hasfile('upload'))
        {
           
                $val = $request->upload ;
                $name = 'upload-' .\Carbon\Carbon::now()->format('Y-m-d')."-".strtotime(\Carbon\Carbon::now()).".".$val->getClientOriginalExtension();
                $tujuan_upload = 'file/customer_upload/';
                // // upload foto
                $val->move($tujuan_upload,$name);
                $path = $tujuan_upload.$name;
                //  dd( $path);

                $header->update([
                    'customer_upload' => $path
                ]);

            
        }
        $input = $request->all();
        foreach ($input['id_detail'] as $key => $value) {
            \App\TCustomerRatingDetail::create([
                't_customer_rating_header_id' =>$header->id,
                'm_customer_rating_item_id' =>$value,
                'rating_score' =>$input['rate'][$key],
            ]);
        }

        

        return "Sukses Update";

    }
}
