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
                $request->session()->flash('trans_form_status', 'Please input the data as per the rules');
                return view('pages.transact');
            }
    
           
    
    
            if($transaction->save()){
                $request->session()->flash('trans_form_status', 'Check your phone for the MPESA notification');
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


}
