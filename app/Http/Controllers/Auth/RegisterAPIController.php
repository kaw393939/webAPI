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
class RegisterAPIController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $input = $request->only('name', 'email', 'password', 'bio');
        $user = User::create($input);
        $user->password = Hash::make($input['password']);
        $user->bio = $input['bio'];
        $user->save();

        $token = auth()->attempt(['email' => $input['email'], 'password' => $input['password']]);

        //refactor this with a custom response class.
        return response()->json([
            'code'   => 201,
            'status' => true,
            'message'=> "Register Success",
            'token' => $token
        ], 201);
    }
}
