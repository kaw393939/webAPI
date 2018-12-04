<?php

namespace App\Http\Controllers\Auth;
use App\Http\Requests\EditUserProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use JWTAuth;
use App\Http\Controllers\Controller;


class GetAuthUserAPIController extends Controller
{
    public function getAuthUser(Request $request)
    {

        $user = JWTAuth::authenticate($request->token);

        return response()->json(['user' => $user]);
    }

    public function editAuthUser(EditUserProfileRequest $request)
    {
        $user = JWTAuth::authenticate($request->token);
        $profile = $request;
        if (Gate::forUser($user)->allows('edit-profile', $profile)) {
            return response()->json([
                'success' => true,
                'message'=> "You may edit this profile",
            ]);
        }
        return response()->json([
            'success' => "false",
            'message'=> "You are unauthorized to edit this profile",
        ]);
    }
}
