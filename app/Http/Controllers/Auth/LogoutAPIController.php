<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\ApiController;

class LogoutAPIController extends ApiController
{
    public function logout(Request $request)
    {

        try {
            JWTAuth::parseToken()->invalidate();
            $data[] = $this->buildDataObject('response',['message' => "User logged out successfully","success"=>true,"status"=>200]);
//            return response()->json([
//                'success' => true,
//                'message' => 'User logged out successfully'
//            ]);
            return $this->apiResponse([$data]);
        } catch (JWTException $exception) {
//            return response()->json([
//                'success' => false,
//                'message' => 'Sorry, the user cannot be logged out'
//            ], 500);
            $data[] = $this->buildDataObject('response',['message' => "Sorry, the user cannot be logged out","success"=>false,"status"=>500]);
            return $this->apiResponse([$data]);
        }
    }
}
