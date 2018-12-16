<?php

namespace App\Http\Controllers\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use JWTAuth;
use App\Http\Controllers\Controller;
use App\Events\LogInEvent;

class LoginAPIController extends Controller
{


    /**
     *
     * @SWG\Post (
     *      path = "/login",
     *      operationId = "loginUser",
     *      tags = {"login"},
     *      summary  = "login user",
     *      description = "login a user",
     *
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
     *          description = "Login Success"
     *      ),
     *     @SWG\Response(response = 422, description = "The given data was invalid"),
     *     )
     *    )
     *
     * Display a listing of the resource.
     *
     */


    public function login(LoginRequest $request)
    {
        $input = $request->only('email', 'password');

        event(new LogInEvent($request->email));

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
