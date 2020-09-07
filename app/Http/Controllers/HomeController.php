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

    public function profileSettings(){
        return view('pages.profile');
    }

    public function updateProfile(Request $request){

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'max:12', 'min:12'],
        ]);

        $updateUser = User::find(1);
        $updateUser->name = $data['name'];
        $updateUser->email = $data['email'];
        $updateUser->phone = $data['phone'];

        if($updateUser->save()){
            $request->session()->flash('profile_form_status', 'Profile details updated successfully :)');
            return redirect(route('user.profile')); 
        }
        else{
            $request->session()->flash('profile_form_status', 'Save operation failed!');
            return view('pages.profile');
        }
    }

    
}
