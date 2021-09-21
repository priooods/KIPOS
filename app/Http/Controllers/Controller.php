<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function RealtimeDates(){
        $dates = Date('D-M-Y');
        return $dates;
    }

    public function HapusSemuaSession(){
        session()->flush();
        return redirect('/user/login');
    }

    public function resSuccess($message,$data){
        return response()->json([
            'error_code' => 0,
            'error_message' => $message,
            $data
        ]);
    }

    public function resEmails($message,$data){
        return response()->json([
            'error_code' => 0,
            'error_message' => $message,
            'data' => $data
        ]);
    }

    public function send_email($fromname, $fromemail, $toname, $toemail, $subject, $data){
        $to_name =  $toname;
        $to_email = $toemail;
        $from_name =  $fromname;
        $from_email = $fromemail;
        try{
            Mail::send("email.gto", $data, function($message) use ($from_name,$from_email,$to_name, $to_email, $subject) {
                $message->to($to_email, $to_name)->subject($subject);
                $message->from($from_email,$from_name);
            });
        }catch(Exception $th){
            return $th;
            // try{
                // EmailFail::create([
                //     'receiver' => $to_email,
                //     'title' => $subject,
                //     'body' => json_encode($data),
                //     'view' => "emails.mail",
                //     'error' => $th->getMessage()
                // ]);
            // }catch(Exception $th){}
        }
    }

    public function resFailed($message){
        return response()->json([
            'error_code' => 1,
            'error_message' => $message
        ]);
    }

    public function resPage($data){
        return response()->json([
            'error_code' => 0,
            'data' => $data->getCollection(),
            'pages' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage()
                ]
            ], 200, []);
    }
}
