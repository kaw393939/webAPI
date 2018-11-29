<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Auth;
use App\Http\Requests\LogoutRequest;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;

class LogoutAPIController extends Controller
{
    public function logout(LogoutRequest $request)
    {

        try {
            JWTAuth::parseToken()->invalidate();

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }
}
