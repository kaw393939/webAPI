<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\ProfilesResource;
use App\User;
use App\Profile;
use DB;
use Illuminate\Http\Request;
use JWTAuth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return new ProfilesResource(ProfileResource::collection(Profile::all()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return ProfileResource
     */
    public function show(Profile $profile)
    {
        ProfileResource::withoutWrapping();
        return new ProfileResource($profile);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $profile->update($request->all());
        $user = User::findOrFail($profile['user_id']);
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => "Profile Updated",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

//public function editProfile()
//{
//    $user = JWTAuth::parseToken()->authenticate();
//    $profile = $user->profile;
//    return response()->json([
//        'code' => 200,
//        'status' => true,
//        'message' => "Can edit profile",
//        'profile' => $profile,
//    ], 200);
//}
//public function updateProfile(UpdateProfileRequest $request) {
//    $input = $request->only('id', 'user_id', 'email', 'first_name', 'last_name', 'bio');
//    $user = User::find($input['user_id']);
//    $profile = Profile::find($input['id']);
//    $user->email = $input['email'];
//    $profile->first_name = $input['first_name'];
//    $profile->last_name = $input['last_name'];
//    $profile->bio = $input['bio'];
//    $profile->save();
//    $user->save();
//    return response()->json([
//        'code' => 200,
//        'status' => true,
//        'message' => "Profile Updated",
//    ], 200);
//}
