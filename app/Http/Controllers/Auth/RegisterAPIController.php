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
     *     name = "first_name",
     *     in = "formData",
     *     type = "string",
     *     description = "first name",
     *     required =true,
     *     ),
     *
     *
     *    @SWG\Parameter(
     *     name = "last_name",
     *     in = "formData",
     *     type = "string",
     *     description = "last name",
     *     required =true,
     *     ),
     *     @SWG\Parameter(
     *     name = "email",
     *     in = "formData",
     *     type = "string",
     *     description = "email",
     *     required =true,
     *     ),
     *
     *      @SWG\Parameter(
     *     name = "bio",
     *     in = "formData",
     *     type = "string",
     *     description = "bio",
     *     required =true,
     *     ),
     *
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
