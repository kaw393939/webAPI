<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUserProfileRequest;
use App\User;
use App\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function createProfile(Request $request) {
        $input = $request->only('first_name', 'last_name', 'bio');
        Profile::class->create($input);
    }
    public function getProfile(Request $request)
    {
        $user = JWTAuth::authenticate($request->token);
        return response()->json(['user' => $user]);
    }
    public function editProfile(EditUserProfileRequest $request, Profile $profile)
    {
        $currentUser = JWTAuth::authenticate($request->token);

        if ($this->authorize($currentUser, $profile)) {
            return response()->json([
                'code' => 200,
                'status' => true,
                'message' => "Can edit profile",
            ], 200);
        }
        return response()->json([
            'code' => 401,
            'status' => false,
            'message' => "Cannot edit profile",
        ], 401);
    }
}
