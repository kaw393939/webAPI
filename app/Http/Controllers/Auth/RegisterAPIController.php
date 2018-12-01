<?php

namespace App\Http\Controllers\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;
class RegisterAPIController extends ApiController
{

    public function register(RegisterRequest $request)
    {
        $input = $request->only('name', 'email', 'password');
        $user = User::create($input);
        $user->password = Hash::make($input['password']);
        $user->save();

        $token = auth()->attempt(['email' => $input['email'], 'password' => $input['password']]);
        $data[] = $this->buildDataObject('response',['message'=> "Register Success",'token' => $token,'status'=>200]);
        //refactor this with a custom response class.
//        return response()->json([
//            'code'   => 201,
//            'status' => true,
//            'message'=> "Register Success",
//            'token' => $token
//        ], 201);
        return $this->apiResponse([$data]);
    }
}
