<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use AfricasTalking\SDK\AfricasTalking;

class CommunicationsController extends Controller
{
    public function newSms(){
        return view('admin.sms');
    }

    public function newNotice(){
        return view('admin.notice');
    }

    public function sendSingle(Request $request){
        $validatedData = $request->validate([
            'singleContact' => ['required', 'numeric'],
            'message' => ['required']
        ]);

        if($validatedData){
            $response = $this->sendSms($request->singleContact, $request->message);
            
            $arr = json_decode($response, true);

            $message = $arr["data"]["SMSMessageData"]["Message"];
            //$new_message = substr($message, 0, strpos($message, "Total"));

            $request->session()->flash('sms_form_status', $message);
            return view('admin.sms');
        }
        else{
            $request->session()->flash('sms_form_status', 'Invalid Form data! plesae try again...');
            return view('admin.sms');
        }
    }

    public function  sendSms($phone, $message){

        $username = "tetrasms";
            $apiKey = "fc4189a9408886c4ea089277c3189b53db65baddd8050d6ea15d55be3985d186";

            // Initialize the SDK
            $AT = new AfricasTalking($username, $apiKey);

            // Get the SMS service
            $sms = $AT->sms();

            // Set the numbers you want to send to in international format
            
            $recipient = "+" . $phone;


            // Set your shortCode or senderId
            $from       = "TetraConcpt";

                try {
                    // Thats it, hit send and we'll take care of the rest
                    $result = $sms->send([
                        'to'      => $recipient,
                        'message' => $message,
                        'from'    => $from
                    ]);
    
                    //echo json_encode($result);
                    return json_encode($result);
                    } catch (Exception $e) {
                    echo "Error: ".$e->getMessage();
                }

    }


}
