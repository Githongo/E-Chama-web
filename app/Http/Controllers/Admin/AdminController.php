<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Loan;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $users = User::all();
        $loanTotal = Loan::where('status', 'Active')->sum('balance');
        $interestTotal = Loan::where('status', 'Active')->sum('interest');
        $requestCount = Loan::where('status', 'Requested')->count();

        return view('admin.dash')->with([
            'users' => $users,
            'loanTotal' => $loanTotal,
            'interestTotal' => $interestTotal,
            'requestCount' => $requestCount
            ]);
    }
}
