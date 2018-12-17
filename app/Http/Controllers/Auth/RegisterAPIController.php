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
use App\Events\RegistrationEvent;

class RegisterAPIController extends Controller
{

    /**
     *
     * @SWG\Post (
     *      path = "/register",
     *      operationId = "registerUser",
     *      tags = {"register"},
     *      summary  = "register user",
     *      description = "registers a user",
     *
     *     @SWG\Parameter(
     *     name = "name",
     *     in = "formData",
     *     type = "string",
     *     description = "name",
     *     required =true,
     *     ),
     *     @SWG\Parameter(
     *     name = "email",
     *     in = "formData",
     *     type = "string",
     *     description = "email",
     *     required =true,
     *     ),
     *     @SWG\Parameter(
     *     name = "password",
     *     in = "formData",
     *     type = "string",
     *     description = "password",
     *     required =true,
     *     ),
     *      @SWG\Response(
     *          response = 200,
     *          description = "successful operation"
     *      ),
     *     @SWG\Response(response = 422, description = "The given data was invalid"),
     *     )
     *    )
     *
     * Display a listing of the resource.
     *
     */

    public function register(RegisterRequest $request)
    {
        $input = $request->only( 'email', 'password');
        $user = User::create($input);
        $user->password = Hash::make($input['password']);
        $user->save();

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
