<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Auth;
use App\Events\LogOutEvent;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use App\User;

class LogoutAPIController extends Controller
{
    /**
     *
     * Display a listing of the resource.
     *
     */


    public function logout(Request $request)
    {

        try {

            event(new LogOutEvent($request->user()));

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
