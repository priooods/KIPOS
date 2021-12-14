<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index($token){
        $data['check'] = \DB::select("
        SELECT 
         t_customer_rating_headers.t_project_header_id,
         t_customer_rating_headers.t_vessel_schedule_id
        FROM 
         t_customer_rating_headers 
        WHERE
         t_customer_rating_headers.token_no = '$token'
        ");

        $query = "
        SELECT 
            t_customer_rating_headers.id,
            t_project_headers.project_no AS description,
            GROUP_CONCAT(m_service_codes.name ORDER BY m_service_codes.name) AS nama_jasa,
            m_customers.name AS nama_customer,
            '' AS vessel_name
        FROM
            (((t_customer_rating_headers JOIN t_project_headers ON t_customer_rating_headers.t_project_header_id = t_project_headers.id)
            JOIN t_project_details ON t_project_headers.id = t_project_details.t_project_header_id)
            JOIN m_service_codes ON t_project_details.m_service_code_id = m_service_codes.id)
            JOIN m_customers ON t_customer_rating_headers.m_customer_id = m_customers.id
        WHERE
            t_customer_rating_headers.token_no = '$token'
            AND t_customer_rating_headers.token_status = '1'
            AND t_project_headers.status_project IN ('O','X')
            AND t_project_details.flag_served = 'Y'
            AND t_project_details.status_close = 'Y'
        GROUP BY
            t_customer_rating_headers.t_vessel_schedule_id,
            t_customer_rating_headers.m_customer_id
        ";
        $is_vessel = $data['check'][0]->t_vessel_schedule_id;
        if($is_vessel != NULL && $is_vessel != ''){
         $query = "
            SELECT 
            t_customer_rating_headers.id,
            IFNULL(t_vessel_schedules.voy_no_in,t_vessel_schedules.voy_no_out) AS description,
            GROUP_CONCAT(m_service_codes.name ORDER BY m_service_codes.name) AS nama_jasa,
            m_customers.name AS nama_customer,
            m_vessels.name AS vessel_name
            FROM 
            ((((((t_customer_rating_headers JOIN t_bookings ON (
            t_customer_rating_headers.t_vessel_schedule_id = t_bookings.t_vessel_schedule_id
            AND t_customer_rating_headers.m_customer_id = t_bookings.m_customer_id
            ))
            JOIN t_project_headers ON t_bookings.id = t_project_headers.t_booking_id)
            JOIN t_project_details ON t_project_headers.id = t_project_details.t_project_header_id)
            JOIN m_service_codes ON t_project_details.m_service_code_id = m_service_codes.id)
            JOIN m_customers ON t_customer_rating_headers.m_customer_id = m_customers.id)
            JOIN t_vessel_schedules ON t_customer_rating_headers.t_vessel_schedule_id = t_vessel_schedules.id)
            JOIN m_vessels ON t_vessel_schedules.m_vessel_id = m_vessels.id
            WHERE
            t_customer_rating_headers.token_no = '$token'
            AND t_customer_rating_headers.token_status = '1'
            AND t_project_headers.status_project IN ('O','X')
            AND t_project_details.flag_served = 'Y'
            AND t_project_details.status_close = 'Y'
            GROUP BY
            t_customer_rating_headers.t_vessel_schedule_id,
            t_customer_rating_headers.m_customer_id";
        }
        $data['informations'] = \DB::select($query);

        if (!isset($data['informations'][0]->id)) {
            return "Terima kasih telah memberikan penilaian." ;
        }
        
        $data['list_item'] = \DB::select("select * from m_customer_rating_items where item_status = 1 and item_flag = 0 order by id asc");
        return view('halaman.survey.survey_index', $data);
    }


    public function update(Request $request, $id)
    {
        // dd($request->all());
       
        $header = \App\TCustomerRatingHeader::where('id', $id)->first();
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