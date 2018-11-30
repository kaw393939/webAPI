<?php

namespace App\Http\Controllers\Auth;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;

class RegisterAPIController extends Controller
{

    public $loginAfterSignUp = true;

    public function register(RegisterRequest $request)
    {

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        if ($this->loginAfterSignUp) {
            return app('App\Http\Controllers\Auth\LoginAPIController')->login($request);
        }
        return response()->json([
            'success' => true,
            'data' => $user
        ], 201);
    }
}
