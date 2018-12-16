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
     * @SWG\Post (
     *      path = "/logout",
     *      operationId = "logoutUser",
     *      tags = {"logout"},
     *      summary  = "logout user",
     *      description = "logout a user",
     *
     *   @SWG\SecurityScheme(
     *         securityDefinition="Bearer",
     *         type="apiKey",
     *         name="Authorization",
     *         in="header"
     *     ),
     *     @SWG\Parameter(
     *     name = "Authorization",
     *     in = "header",
     *     type = "string",
     *     description = "Bearer TOKEN",
     *     required =true,
     *
     *     ),
     *
     *      @SWG\Response(
     *          response = 200,
     *          description = "succes: true"
     *      ),
     *     @SWG\Response(response = 422, description = "The given data was invalid"),
     *     )
     *    )
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
