<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function authenticate(Request $request){
        $validator = Validator::make($request->all(), [ 
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string']
        ]);
        if ($validator->fails()) { 
            return response([
                "success" => 0,
                "message" => "Input data is invalid",
                "errors"=>$validator->errors()
            ]);          
        }

        if (Auth::attempt(request(['email', 'password']))) {
            $user = new UserResource((Auth::user()));
            $token = Auth::user()->createToken('authToken')->accessToken;
            return response([
                "success" => 1,
                "authorized" => true,
                "message" => "Authenticated successfully",
                "user" => Auth::user(),
                "token" => $token
            ]);
        }
        else{
            return response([
                "success" => 0,
                "authorized" => false,
                "message" => "Invalid Credentials"
            ]);
        }
    }

    public function resetPassword(Request $request){  

        $validator = Validator::make($request->all(), [ 
            'email' => ['required', 'string', 'email']
        ]);
        if ($validator->fails()) { 
            return response([
                "success" => 0,
                "message" => "Input data is invalid",
                "errors"=>$validator->errors()
            ]);          
        }
        $email = request('email');

        return response([
            "success" => 1,
            "message" => "Password reset request sent successfully to email."
        ]);

    }
}