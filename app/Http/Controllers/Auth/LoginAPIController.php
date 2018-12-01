<?php

namespace App\Http\Controllers\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use JWTAuth;
use App\Http\Controllers\ApiController;

class LoginAPIController extends ApiController
{

    /**
     * @param LoginRequest $request
     * @return mixed
     */
    public function login(LoginRequest $request)
    {
        $input = $request->only('email', 'password');
        $jwt_token = JWTAuth::attempt($input);
        $data[] = $this->buildDataObject('authtoken',['token' => $jwt_token]);
        //refactor to use custom response class
//        return response()->json([
//            'code'   => 200,
//            'status' => true,
//            'message'=> "Login Success",
//            'token' => $jwt_token,
//        ], 200);
//    }
        return $this->apiResponse([$data]);

    }
}
