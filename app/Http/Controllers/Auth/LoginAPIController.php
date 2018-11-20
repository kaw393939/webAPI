<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use JWTAuth;
use App\Http\Controllers\Controller;

class LoginAPIController extends Controller
{

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $jwt_token = null;
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => "false",
                'message' => "Invalid Email or Password",
            ], 401);
        }
        return response()->json([
            'success' => true,
            'token' => $jwt_token,
        ]);
    }
}
