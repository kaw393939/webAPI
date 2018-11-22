<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use JWTAuth;
use App\Http\Controllers\Controller;


class GetAuthUserAPIController extends Controller
{
    public function getAuthUser(Request $request)
    {

        $user = JWTAuth::authenticate($request->token);

        return response()->json(['user' => $user]);
    }
}
