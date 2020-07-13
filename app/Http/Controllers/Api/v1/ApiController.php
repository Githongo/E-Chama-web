<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as UserResource;
use App\Loan;
use App\Transaction;
use App\User;

class ApiController extends Controller
{

    //Create and store new Loan
    public function newLoan(Request $request){
        //Check if user has an existing request for a loan
        if(Loan::where('user_id', '=', request('user_id'))->where( 'status', '=', "Requested" )->exists()){
            return json_encode(["data" => [
                "success" => 0,
                "submitted" => false,
                "message" => "You Already have an existing Request for a Loan!"
            ]]);
        }
        if(!User::where('id', '=', request('user_id'))->exists()){
            return json_encode(["data" => [
                "success" => 0,
                "submitted" => false,
                "message" => "The User Identifier provided is invalid"
            ]]);
        }

        //validate request data
        $validatedData = $request->validate([
            'grant_date' => ['required'],
            'repayment_date' => ['required'],
            'amount' => ['required', 'numeric', 'min:1000'],
            'repayment_period' => ['required']
        ]);

        //Insert validated data to DB
        if($validatedData){
            $amt = request('amount');
            $repay_period = request('repayment_period');
            $interest = (0.005 * $repay_period) * $amt ;
            $balance = ($amt + $interest);

            $loan = new Loan;
            $loan->user_id = request('user_id');
            $loan->amount = request('amount');
            $loan->interest = $interest;
            $loan->balance = $balance;
            $loan->repayment_period = request('repayment_period');
            $loan->status = "Requested";
            $loan->grant_date = request('grant_date');
            $loan->start_date = request('repayment_date');
        }
        else{
            return json_encode(["data" => [
                "success" => 0,
                "submitted" => false,
                "message" => "Input validation failed"
            ]]);
        }

        //JSON Response
        if($loan->save()){
            return json_encode(["data" => [
                "success" => 1,
                "submitted" => true,
                "message" => "Loan Application Successful"
            ]]);
        }else{
            return json_encode(["data" => [
                "success" => 0,
                "submitted" => false,
                "message" => "Loan Application failed, please try agaoin later"
            ]]);
        }

        
    }

    //Create and store a new Transaction
    public function newTransaction(Request $request){
        if(!User::where('id', '=', request('user_id'))->exists()){
            return response(["data" => [
                "success" => 0,
                "submitted" => false,
                "message" => "The User Identifier provided is invalid"
            ]]);
        }

        $validatedData = $request->validate([
            'amount' => ['required', 'numeric', 'min:100'],
            'phone' => ['required', 'numeric']
        ]);

            /*Validate request Data
            if($validatedData){
                $transaction = new Transaction;
                $transaction->user_id = Auth::id();
                $transaction->type = request('type');
                $transaction->amount = request('amount');
                $transaction->status = "Requested"; 
                
                //Update Wallet/Laon Balance
                if(request('type') == '1'){
                    //Check for active Loan to update balance
                    if(Loan::where('user_id', '=', Auth::id())->where( 'status', '=', "Active" )->exists()){
                        $loan = Loan::where('user_id', '=', Auth::id())->where( 'status', '=', "Active" )->first();
                        $prevBal = $loan->balance;
                        $loan->balance = ($prevBal - request('amount'));
                        $loan->save();
                    }
                    else{
                        return response(["data" => [
                            "success" => 0,
                            "submitted" => false,
                            "message" => "You have no active loans to service"
                        ]]);
                    }
                           
                }
                elseif(request('type') == '2'){
                    $user = User::findOrFail(request('user_id')); 
                    $prevBal = $user->wallet;
                    $user->wallet = ($prevBal + request('amount'));
                    $user->save(); 
                }
           
            }
            else{
                
                return response(["data" => [
                    "success" => 0,
                    "submitted" => false,
                    "message" => "Input validation failed"
                ]]);
            }
    
            //JSON ResponseFeedback
            if($transaction->save()){    
                return response(["data" => [
                    "success" => 1,
                    "submitted" => true,
                    "message" => "Request Successful, check your phone for STK Push notification"
                ]]);
            }else{
                return response(["data" => [
                    "success" => 0,
                    "submitted" => false,
                    "message" => "Transaction failed, please try agaoin later"
                ]]);
            }
            */


            //New

            if($validatedData){
                $transaction = new Transaction;
                $transaction->user_id = Auth::id();
                $transaction->type = request('type');
                $transaction->amount = request('amount');
                $transaction->status = "Requested"; 

                $mpesa= new \Safaricom\Mpesa\Mpesa();

                $callback_url = "https://8c92a58071e4.ngrok.io/payment/response";
                $stkPushSimulation=$mpesa->STKPushSimulation(
                    '174379', //Bussiness Short Code
                    'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
                    'CustomerPayBillOnline',// Transaction Type
                    '1', 
                    $request->phone, //Party A - phone of the customer
                    '174379', //Party B - same as Business Short Code
                    $request->phone, //Phone number
                    $callback_url,
                    'E-chama',
                    'test',
                    ''
                );
                
                $resp = json_decode($stkPushSimulation, true);
                $reqId = $resp['CheckoutRequestID'];

                session(['ApireqID' => $reqId]);
                //echo $reqId;

                if($stkPushSimulation){
                    if($this->confirmPayment()){
                        //echo "Hello mamammuuuii";
                        if(request('type') == '1'){
                            if(Loan::where('user_id', '=', Auth::id())->where( 'status', '=', "Active" )->exists()){
                                $loan = Loan::where('user_id', '=', Auth::id())->where( 'status', '=', "Active" )->first();
                                /*foreach ($loans as $loan) {
                                    $prevBal = $loan->balance;
                                    $loan->balance = ($prevBal - request('amount'));
                                    $loan->save();
                                }*/
                                $prevBal = $loan->balance;
                                $loan->balance = ($prevBal - request('amount'));
                                $loan->save();
                            }
                            else{
                                return response(["data" => [
                                    "success" => 0,
                                    "submitted" => false,
                                    "message" => "You have no active loans to service"
                                ]]);
                            }
                                
                        }
                        elseif(request('type') == '2'){
                            $user = User::findOrFail(request('user_id')); 
                            $prevBal = $user->wallet;
                            $user->wallet = ($prevBal + request('amount'));
                            $user->save(); 
                        }
                        
                    }
                    else{
                        return response(["data" => [
                            "success" => 0,
                            "processed" => false,
                            "message" => "An error occured, payment not recieved"
                        ]]);
                    }
                }
           
            }
            else{
                return response(["data" => [
                    "success" => 0,
                    "processed" => false,
                    "message" => "Input validation failed"
                ]]);
            } 
    
            if($transaction->save()){
                return response(["data" => [
                    "success" => 1,
                    "processed" => true,
                    "message" => "Payment recieved! Transaction completed successfully..."
                ]]);
            }else{
                return response(["data" => [
                    "success" => 0,
                    "processed" => false,
                    "message" => "Transaction failed, please try agaoin later"
                ]]);
            }


    }

    public function confirmPayment(){
        $transResponse = json_decode($this->getSTKPushStatus());
        global $success;
            if(property_exists($transResponse, 'errorCode')){
                //echo $transResponse->errorMessage;
                sleep(1);
                $this->confirmPayment(); 
            }
            else{
                if($transResponse->ResultCode == 0){
                    //echo $transResponse->ResultDesc;
                    $success = true;
                }
                elseif($transResponse->ResultCode == 1032){
                    //echo $transResponse->ResultDesc;
                    $success = false;
                    $errorMsg = (["data" => [
                        "success" => 0,
                        "error" => "Transaction failed! Request Cancelled by user"
                    ]]);
                    //echo json_encode($errorMsg);

                }
                else{
                
                    $success = false;
     
                }
            }

            return $success;
    }

    public function getSTKPushStatus(){
        $mpesa = new \Safaricom\Mpesa\Mpesa();
        $STKPushRequestStatus=$mpesa->STKPushQuery(session('ApireqID'));
        return $STKPushRequestStatus;
    }

}
