<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaction;
use App\Loan;
use App\User;

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
        //$this->sendSTK();
        //$this->getSTKPushStatus();
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
                $transaction->status = "Requested"; 
                
                if($this->sendSTK()){

                
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
                            $request->session()->flash('trans_form_status', 'You do not have any active loans to service');
                            return view('pages.transact');
                        }
                            
                    }
                    elseif(request('type') == '2'){
                        $user = User::findOrFail(Auth::id()); 
                        $prevBal = $user->wallet;
                        $user->wallet = ($prevBal + request('amount'));
                        $user->save(); 
                    }
                }
                else{
                    return view('pages.transaact');
                }
           
            }
            else{
                $request->session()->flash('trans_form_status', 'Please input the data as per the rules');
                return view('pages.transact');
            }
    
           
    
    
            if($transaction->save()){
                $request->session()->flash('trans_form_status', 'Transaction completed successfully :)');
                return view('pages.transact');
            }else{
                $request->session()->flash('trans_form_status', 'Transaction failed...please try again');
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

    public function sendSTK(){   

        $mpesa= new \Safaricom\Mpesa\Mpesa();

        $callback_url = "https://8c92a58071e4.ngrok.io/payment/response";
        $stkPushSimulation=$mpesa->STKPushSimulation(
            '174379', //Bussiness Short Code
            'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
            'CustomerPayBillOnline',// Transaction Type
            '1', 
            '254710113242', //Party A - phone of the customer
            '174379', //Party B - same as Business Short Code
            '254710113242', //Phone number
            $callback_url,
            'E-chama',
            'test',
            ''
        );

        
        $resp = json_decode($stkPushSimulation, true);
        $reqId = $resp['CheckoutRequestID'];

        session(['reqID' => $reqId]);

        //echo $reqId;

        if($stkPushSimulation){
            $transResponse = json_decode($this->getSTKPushStatus());
            //echo $transResponse->ResultDesc; 
            if(1 != 1){
                //do nothing
            }
            elseif($transResponse->ResultCode == 0){
                echo "Payment successful";
                return true;
            }
            elseif($transResponse->ResultCode == 1032){
                echo "Mpesa Transaction cancelled by user";
                $request->session()->flash('trans_form_status', 'Failed! Transaction cancelled by user');
                return false;
            }
            elseif($transResponse->errorCode == "500.001.1001"){
                echo "Your request is being processed";
                $this->sendSTK();       
            }
            else{
                $request->session()->flash('trans_form_status', 'Something went wrong, please try again later');
                return false;  
            }

        }
        

    }

    public function getSTKPushStatus(){
        $mpesa = new \Safaricom\Mpesa\Mpesa();
        $STKPushRequestStatus=$mpesa->STKPushQuery(session('reqID'));
        return $STKPushRequestStatus;
    }

    /*
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

        
        
    }*/

    
    


}
