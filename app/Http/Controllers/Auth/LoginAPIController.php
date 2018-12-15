<?php

namespace App\Http\Controllers\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use JWTAuth;
use App\Http\Controllers\Controller;

class LoginAPIController extends Controller
{

    public function login(LoginRequest $request)
    {
        $input = $request->only('email', 'password');

        try {

            if (! $jwt_token = JWTAuth::attempt($input)) {
                return response()->json([
                    'code' => 401,
                    'status' => false,
                    'message' => "Login Failed",
                ], 401);
            }

            //refactor to use custom response class
            return response()->json([
                'code' => 200,
                'status' => true,
                'message' => "Login Success",
                'token' => $jwt_token,
            ], 200);

        } catch (JWTException $exception) {
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => "Login Error",
            ], 500);
        }
    }


}
