<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\User;
use App\Profile;
use DB;
use Illuminate\Http\Request;
use JWTAuth;

class ProfileController extends Controller
{
    public function createProfile(Request $request) {
        $user = JWTAuth::parseToken()->authenticate();

        try {
            $input = $request->only('first_name', 'last_name', 'bio');
            $profile = Profile::make();
            $profile->user_id = $user['id'];
            $profile->fill($input);
            $profile->save();
            return response()->json([
                'code' => 200,
                'status' => true,
                'message' => "Profile Created",
            ], 200);
        }
        catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => "Profile Error",
            ], 500);
        }
    }
    public function showProfile(Request $request)
    {
        $input = $request->only('id');
        $profile = Profile::find($input['id']);
        if ($profile) {
            return response()->json([
                'code' => 200,
                'status' => true,
                'message' => "Profile Found",
                'profile' => $profile,
            ], 200);
        }
        return response()->json([
            'code' => 200,
            'status' => false,
            'message' => "Profile Not Found",
        ], 200);
    }
    public function editProfile()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $profile = $user->profile;
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => "Can edit profile",
            'profile' => $profile,
        ], 200);
    }
    public function updateProfile(UpdateProfileRequest $request) {
        $input = $request->only('id', 'user_id', 'email', 'first_name', 'last_name', 'bio');
        $user = User::find($input['user_id']);
        $profile = Profile::find($input['id']);
        $user->email = $input['email'];
        $profile->first_name = $input['first_name'];
        $profile->last_name = $input['last_name'];
        $profile->bio = $input['bio'];
        $profile->save();
        $user->save();
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => "Profile Updated",
        ], 200);
    }
}
