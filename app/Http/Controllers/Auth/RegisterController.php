<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\RegistrationEvent;

/**
 * Class RegisterAPIController
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{

    /**
     *
     *
     * Display a listing of the resource.
     *
     */

    public function register(RegisterRequest $request)
    {
        $input = $request->only('email', 'password', 'first_name', 'last_name', 'bio');
        $profileInput = $request->only('first_name', 'last_name', 'bio');
        $user = User::create($input);
        $user->password = Hash::make($input['password']);
        $user->save();
        $profile = Profile::create($profileInput);
        $profile->user()->associate($user);
        $profile->save();

        $token = auth()->attempt(['email' => $input['email'], 'password' => $input['password']]);

        event(new RegistrationEvent($user));

        //refactor this with a custom response class.
        return response()->json([
            'code'   => 201,
            'status' => true,
            'message'=> "Register Success",
            'token' => $token
        ], 201);
    }
}
