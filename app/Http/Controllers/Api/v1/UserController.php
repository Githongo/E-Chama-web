<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use App\Transaction;
use App\Notice;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response([
            "success" => 1,
            "message" => "Fetched all users",
            "users" => $users
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'max:12', 'min:12', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], 
            
        ]);
        if ($validator->fails()) { 
            return response([
                "success" => 0,
                "message" => "Input data is invalid",
                "errors"=>$validator->errors()
            ]);          
        }

        $newUser = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'phone' => request('phone'),
            'wallet' => 0.00,
            'password' => Hash::make(request('password')),
        ]);

        //attach user role
        $role = Role::select('id')->where('name', 'user')->first();
        $newUser->roles()->attach($role);

        return response([
            "success" => 1,
            "message" => "User registered successfully",
            "user" => $newUser
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!User::where('id', '=', $id)->exists()){
            return response([
                "success" => 0,
                "submitted" => false,
                "message" => "The User Identifier provided is invalid"
            ]);
        }

        $foundUser = User::find($id);

        return response([
            "success" => 1,
            "message" => "User found",
            "user" => $foundUser
        ]);

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
    public function update(Request $request)
    {
        if(!User::where('id', '=', request('user_id'))->exists()){
            return response([
                "success" => 0,
                "submitted" => false,
                "message" => "The User Identifier provided is invalid"
            ]);
        }

        $validator = Validator::make($request->all(), [ 
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'max:12', 'min:12'],
            
        ]);
        if ($validator->fails()) { 
            return response([
                "success" => 0,
                "message" => "Input data is invalid",
                "errors"=>$validator->errors()
            ]);          
        }

        if($validator){
            $updateUser = User::find(request('user_id'));
            $updateUser->name = request('name');
            $updateUser->email = request('email');
            $updateUser->phone = request('phone');

            if($updateUser->save()){
                return response([
                    "success" => 1,
                    "updated" => true,
                    "message" => "User details updated successfully",
                    "updates" => $updateUser
                ]);
            }
            else{
                return response([
                    "success" => 0,
                    "updated" => false,
                    "message" => "User detail update operation failed"
                ]);
            }
        }
        else{
            return response([
                "success" => 0,
                "updated" => false,
                "message" => "Input validation failed"
            ]);
        }

        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function transHistory($id){
        $transactions = Transaction::where('user_id', '=', $id)->get();

        return response([
            "success" => 1,
            "processed" => true,
            "message" => "Transaction History retrieved successfully",
            "data" => $transactions
        ]);
    }

    public function getNotices(){
        $notices = Notice::all();

        return response([
            "success" => 1,
            "message" => "Notices retrived successfully",
            "data" => $notices
        ]);

    }

    
}
