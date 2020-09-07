<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Loan;


class LoansController extends Controller
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
        return view('pages.newloan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if(Loan::where('user_id', '=', Auth::id())->where( 'status', '=', "Requested" )->exists()){
            $request->session()->flash('loan_form_status', 'You already have a loan pending approval, Please try again Later');
            return view('pages.newloan');
        }

        $validatedData = $request->validate([
            'grant_date' => ['required'],
            'repayment_date' => ['required'],
            'amount' => ['required', 'numeric', 'min:1000'],
            'repayment_period' => ['required']
        ]);

        if($validatedData){
            $amt = request('amount');
            $repay_period = request('repayment_period');
            $interest = (0.005 * $repay_period) * $amt ;
            $balance = ($amt + $interest);

            $loan = new Loan;
            $loan->user_id = Auth::id();
            $loan->amount = request('amount');
            $loan->interest = $interest;
            $loan->balance = $balance;
            $loan->repayment_period = request('repayment_period');
            $loan->status = "Requested";
            $loan->grant_date = request('grant_date');
            $loan->start_date = request('repayment_date');
        }
        else{
            $request->session()->flash('loan_form_status', 'Please input the data as per the rules');
            return view('pages.newloan');
        }

       


        if($loan->save()){
            $request->session()->flash('loan_form_status', 'Loan Application Submitted');
            return ('pages.newloan');
        }else{
            $request->session()->flash('loan_form_status', 'Loan application failed...please try again');
            return view('pages.newloan');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Loan $loan)
    {
        $loan->status = "Active";
        if($loan->save()){
            return view('admin.loanreq');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();
        return redirect(route('admin.loans.requests'));
    }
}
