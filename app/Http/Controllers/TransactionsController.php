<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaction;
use App\Loan;
use App\User;
use AfricasTalking\SDK\AfricasTalking;

class TransactionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.transact');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'amount' => ['required', 'numeric', 'min:100'],
            'phone' => ['required', 'numeric']
        ]);


            
            if($validatedData){
                $transaction = new Transaction;
                $transaction->user_id = Auth::id();
                $transaction->type = request('type');
                $transaction->amount = request('amount');
                $transaction->status = "Unsuccessful";

                $mpesa= new \Safaricom\Mpesa\Mpesa();

                $callback_url = "https://mchamatest.jeffreykingori.dev/payment/response";
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

                //echo $stkPushSimulation;
                
                if($stkPushSimulation){
                    $resp = json_decode($stkPushSimulation, true);
                    $reqId = $resp['CheckoutRequestID'];

                    session(['reqID' => $reqId]);
                }
                

                //echo $reqId;

                if($stkPushSimulation){
                    if($this->confirmPayment()){
                        //updating transaction status
                        $transaction->status = "Complete";

                        if(request('type') == '1'){
                            if(Loan::where('user_id', '=', Auth::id())->where( 'status', '=', "Active" )->exists()){
                                $loan = Loan::where('user_id', '=', Auth::id())->where( 'status', '=', "Active" )->first();
                                
                                $prevBal = $loan->balance;
                                $loan->balance = ($prevBal - request('amount'));
                                $loan->save();
                                $loanMsg = "Dear ".Auth::user()->name.", your Loan has been serviced by KSh.". strval(request('amount'))." your new Loan balance is KSh.". strval($loan->balance);
                                $this->sendSms($request->phone, $loanMsg);
                            }
                            else{
                                $request->session()->flash('trans_form_status', 'You do not have any active loans to service');
                                return view('pages.transact');
                            }
                                
                        }
                        elseif(request('type') == '2'){
                            $user = User::findOrFail(Auth::id()); 
                            $prevBal = $user->wallet;
                            $user->wallet = ($prevBal + request('amount'));
                            $user->save();
                            $msg = "Dear ".$user->name.", KSh. ".strval(request('amount'))." has been credited to your M-Wallet. New M-Wallet balance is KSh. ".strval($user->wallet);
                            $this->sendSms($request->phone, $msg);
                        }
                        
                    }
                    else{
                        //echo "Wrong bark daawg";
                        return view('pages.transact');
                        
                    }
                }
           
            }
            else{
                $request->session()->flash('trans_form_status', 'Please input the data as per the rules');
                return view('pages.transact');
            } 
    
            if($transaction->save()){
                $request->session()->flash('trans_form_status', 'Payment recieved. Transaction completed successfully :)');
                return view('pages.transact');
            }else{
                $request->session()->flash('trans_form_status', 'Payment recieved but Transaction failed...please contact treasurer');
                return view('pages.transact');
            }
            
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function sendSms($phone, $message){

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
                    //echo json_encode($result);
                    } catch (\Exception $e) {
                    echo "Error: ".$e->getMessage();
                }

    }

    public function sendSTK($phone, $amount){   

        $mpesa= new \Safaricom\Mpesa\Mpesa();

        $callback_url = "https://mchamatest.jeffreykingori.dev/payment/response";
        $stkPushSimulation=$mpesa->STKPushSimulation(
            '174379', //Bussiness Short Code
            'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
            'CustomerPayBillOnline',// Transaction Type
            '1', 
            $phone, //Party A - phone of the customer
            '174379', //Party B - same as Business Short Code
            $phone, //Phone number
            $callback_url,
            'E-chama',
            'test',
            ''
        );

        if($stkPushSimulation){
            $resp = json_decode($stkPushSimulation, true);
            $reqId = $resp['CheckoutRequestID'];

            session(['reqID' => $reqId]);
        }
        

        //echo $reqId;

        if($stkPushSimulation){
            if($this->confirmPayment()){
                return true;
            }
            else{
                return false;
            }
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
                    session()->flash('trans_form_status', 'Success! Your Payment has been recieved...');
                    $success = true;
                }
                elseif($transResponse->ResultCode == 1032){
                    //echo $transResponse->ResultDesc;
                    session()->flash('trans_form_status', 'Failed! Transaction cancelled by user');
                    $success = false;
                
                }
                else{
                    session()->flash('trans_form_status', 'Something went wrong, please try again...');
                    $success = false;
     
                }
            }

            return $success;
    }

    public function getSTKPushStatus(){
        $mpesa = new \Safaricom\Mpesa\Mpesa();
        $STKPushRequestStatus=$mpesa->STKPushQuery(session('reqID'));
        return $STKPushRequestStatus;
    }

    
    public static function processSTKPushRequestCallback(){
        $callbackJSONData=file_get_contents('php://input');
        $callbackData=json_decode($callbackJSONData);
        $resultCode=$callbackData->Body->stkCallback->ResultCode;
        $resultDesc=$callbackData->Body->stkCallback->ResultDesc;
        $merchantRequestID=$callbackData->Body->stkCallback->MerchantRequestID;
        $checkoutRequestID=$callbackData->Body->stkCallback->CheckoutRequestID;

        $amount=$callbackData->stkCallback->Body->CallbackMetadata->Item[0]->Value;
        $mpesaReceiptNumber=$callbackData->Body->stkCallback->CallbackMetadata->Item[1]->Value;
        $balance=$callbackData->stkCallback->Body->CallbackMetadata->Item[2]->Value;
        $b2CUtilityAccountAvailableFunds=$callbackData->Body->stkCallback->CallbackMetadata->Item[3]->Value;
        $transactionDate=$callbackData->Body->stkCallback->CallbackMetadata->Item[4]->Value;
        $phoneNumber=$callbackData->Body->stkCallback->CallbackMetadata->Item[5]->Value;
/*
        $callbackData=$mpesa->finishTransaction();

        $newTransaction = new Transaction;
                $newTransaction->user_id = 15;
                $newTransaction->type = 10;
                $newTransaction->amount = 5000;
                $newTransaction->status = "Processing"; 
                $newTransaction->save();


        if($resultCode == 0){

            echo $mpesaReceiptNumber;
            $Message = $request->$resultDesc;
            $request->session()->flash('trans_form_status', $Message);
            return view('pages.transact');
            
        }
        else{
            $request->session()->flash('trans_form_status', 'Transaction not completed');
            return view('pages.transact');
        }     
        */
    }

    
    


}
