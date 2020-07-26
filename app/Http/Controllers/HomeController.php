<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Notice;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $notices = Notice::all();
        
        return view('home')->with(['title' => 'Home', 'notices' => $notices]);
    }

    public function rotationList(){
        $users = User::all();
        return view('pages.rotationlist')->with('users', $users);
    }

    
}
