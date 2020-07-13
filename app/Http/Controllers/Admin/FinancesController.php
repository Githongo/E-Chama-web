<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Loan;
use App\Account;


class FinancesController extends Controller
{
    public function allLoans(){
        $loans = Loan::where('status', 'Active')->get();
        return view('admin.loans')->with('loans', $loans);
    }

    public function loanRequests(){
        $loans = Loan::where('status', 'Requested')->get();
        return view('admin.loanreq')->with('loans', $loans);
    }

    public function accounts(){
        $accounts = Account::all();
        return view('admin.accounts')->with('accounts', $accounts);
    }

    public function newContributions(){

        return view('admin.newcontribution');
    }

    public function accountTransfer(Request $request){
        if($request->name_1 == "Main"){
            $mainAcc = Account::where('type', 'Main')->get();
            $mainBal = $mainAcc->balance;
            $mainAcc->balance = $mainBal - $request->amount;
            if($request->name_2 == "Loan" ){
                $loanAcc = Account::where('type', 'Loan')->get();
                $loanBal = $loanAcc->balance;
                $loanAcc->balance = $loanBal + $request->amount;
            }
        }
    }
}
