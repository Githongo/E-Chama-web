<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

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

        return response(["data" => [
            "success" => 1,
            "message" => "Fetched all users",
            "users" => $users
        ]]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'max:12', 'min:12', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $newUser = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'wallet' => 0.00,
            'password' => Hash::make($data['password']),
        ]);

        return response(["data" => [
            "success" => 1,
            "message" => "User registered successfully",
            "user" => $newUser
        ]]);
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
    public function update(Request $request)
    {
        if(!User::where('id', '=', request('user_id'))->exists()){
            return response(["data" => [
                "success" => 0,
                "submitted" => false,
                "message" => "The User Identifier provided is invalid"
            ]]);
        }

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'max:12', 'min:12'],
        ]);

        if($validatedData){
            $updateUser = User::find(request('user_id'));
            $updateUser->name = request('name');
            $updateUser->email = request('email');
            $updateUser->phone = request('phone');

            if($updateUser->save()){
                return response(["data" => [
                    "success" => 1,
                    "updated" => true,
                    "message" => "User details updated successfully",
                    "updated" => $updateUser
                ]]);
            }
            else{
                return response(["data" => [
                    "success" => 0,
                    "updated" => false,
                    "message" => "User detail update operation failed"
                ]]);
            }
        }
        else{
            return response(["data" => [
                "success" => 0,
                "updated" => false,
                "message" => "Input validation failed"
            ]]);
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

    
}
