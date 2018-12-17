<?php

namespace App\Http\Controllers\Auth;
use App\Http\Requests\ProfileUpdateRequest;
use App\Profile;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use JWTAuth;
use App\Http\Controllers\Controller;


class GetAuthUserAPIController extends Controller
{
    public function getAuthUser(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $profile = Profile::where('user_id', $user->id)->firstOrFail();

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'User Successfully Retrieved',
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'first_name' => $profile->first_name,
                'last_name' => $profile->last_name,
                'bio' => $profile->bio,
                ]
        ], 200);
    }
}
