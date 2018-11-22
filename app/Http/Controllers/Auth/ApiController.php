<?php
namespace App\Http\Controllers\Auth;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;

class ApiController extends Controller
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
            return $this->login($request);
        }
        return response()->json([
            'success' => true,
            'data' => $user
        ], 201);
    }

    //Remove this function after refactoring the register method
    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $jwt_token = null;
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => "false",
                'message' => "Invalid Email or Password",
            ], 401);
        }
        return response()->json([
            'success' => true,
            'token' => $jwt_token,
        ]);
    }

    public function getAuthUser(Request $request)
    {

        $user = JWTAuth::authenticate($request->token);

        return response()->json(['user' => $user]);
    }
}
