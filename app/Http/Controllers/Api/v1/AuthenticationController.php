<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string']
        ]);

        if (Auth::attempt($credentials)) {
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
        $email = $request->validate(['email' => ['required', 'email']]);

        return response([
            "success" => 1,
            "message" => "Password reset request sent successfully to email."
        ]);

    }
}
