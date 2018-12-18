<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileCreateRequest;
use App\Http\Requests\ProfileDeleteRequest;
use App\Http\Requests\ProfileUpdateRequest;
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
     *
     * @SWG\Get (
     *      path = "/profiles",
     *      operationId = "getProfiles",
     *      tags = {"Profiles"},
     *      summary  = "Get list of Profiles",
     *      description = "return list of profiles",
     *      @SWG\Response(
     *          response = 200,
     *          description = "successful operation"
     *      ),
     *     @SWG\Response(response = 400, description = "Bad request"),
     *     )
     *    )
     *
     * Display a listing of the resource.
     *
     */
    /**
     *
     *
     *
     *
     *
     *
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
     *
     *  * @SWG\Post (
     *      path = "/profiles/",
     *      operationId = "createProfile",
     *      tags = {"Profiles"},
     *      summary  = "create a  user profile",
     *      description = "Create a user's profile",
     *
     *   @SWG\SecurityScheme(
     *         securityDefinition="Bearer",
     *         type="apiKey",
     *         name="Authorization",
     *         in="header"
     *     ),
     *
     *
     *     @SWG\Parameter(
     *     name = "first name",
     *     in = "formData",
     *     type = "string",
     *     description = "first name",
     *     required =true,
     *     ),
     *     @SWG\Parameter(
     *     name = "last name",
     *     in = "formData",
     *     type = "string",
     *     description = "last name",
     *     required =true,
     *     ),
     *
     *
     *     @SWG\Parameter(
     *     name = "bio",
     *     in = "formData",
     *     type = "string",
     *     description = "bio text",
     *     required =true,
     *     ),
     *
     *
     *
     *
     *
     *
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
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfileCreateRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $input = $request->only('first_name', 'last_name', 'bio');

        try {
            $profile = Profile::create($input);
            $profile->user_id = $user->id;
            $profile->save();
            return response()->json([
                'id' => $profile->id,
                'code' => 200,
                'status' => true,
                'message' => "Create Success",
            ], 200);
        }
        catch(\Exception $exception) {
            return response()->json([
                'code' => 404,
                'status' => false,
                'message' => "Create Fail",
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * /**
     * @SWG\Get (
     *      path = "/profiles/{id}",
     *      operationId = "getProfileById",
     *      tags = {"Profiles"},
     *      summary  = "Get profile info",
     *      description = "return profile data",
     * @SWG\Parameter(
     *     name = "id",
     *     in = "path",
     *     type = "string",
     *     description = "id",
     *     required =true,
     *     ),
     *      @SWG\Response(
     *          response = 200,
     *          description = "successful operation",
     *      ),
     *     @SWG\Response(response = 400, description = "Bad request"),
     *    )
     *
     *
     *
     *
     *
     *
     *
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
     *
     *
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
     *
     *  * /**
     *
     * @SWG\Put (
     *      path = "/profiles/{id}",
     *      operationId = "editProfile",
     *      tags = {"Profiles"},
     *      summary  = "edit a  user profile",
     *      description = "Edit a user's profile",
     *
     *   @SWG\SecurityScheme(
     *         securityDefinition="Bearer",
     *         type="apiKey",
     *         name="Authorization",
     *         in="header"
     *     ),
     * @SWG\Parameter(
     *     name = "id",
     *     in = "path",
     *     type = "string",
     *     description = "id",
     *     required =true,
     *     ),
     *
     *     @SWG\Parameter(
     *     name = "email",
     *     in = "formData",
     *     type = "string",
     *     description = "email",
     *     required =true,
     *     ),
     *
     *
     *
     *     @SWG\Parameter(
     *     name = "first name",
     *     in = "formData",
     *     type = "string",
     *     description = "first name",
     *     required =true,
     *     ),
     *     @SWG\Parameter(
     *     name = "last name",
     *     in = "formData",
     *     type = "string",
     *     description = "last name",
     *     required =true,
     *     ),
     *
     *
     *     @SWG\Parameter(
     *     name = "bio",
     *     in = "formData",
     *     type = "string",
     *     description = "bio text",
     *     required =true,
     *     ),
     *
     *
     *
     *
     *
     *
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
     *
     *
     *
     *
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileUpdateRequest $request, $id)
    {
        try {
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
        catch (\Exception $e) {
            return response()->json([
                'code' => 404,
                'status' => true,
                'message' => "Profile Update Failed",
            ], 404);
        }
    }

    /**
     *
     *  /**
     *
     * * @SWG\Delete (
     *      path = "/profiles/{id}",
     *      operationId = "deleteProfile",
     *      tags = {"Profiles"},
     *      summary  = "delete a  user profile",
     *      description = "Delete a user's profile",
     *
     *   @SWG\SecurityScheme(
     *         securityDefinition="Bearer",
     *         type="apiKey",
     *         name="Authorization",
     *         in="header"
     *     ),
     * @SWG\Parameter(
     *     name = "id",
     *     in = "path",
     *     type = "string",
     *     description = "id",
     *     required =true,
     *     ),
     *
     *
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
     *
     *
     *
     *
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfileDeleteRequest $request, $id)
    {
        if(Profile::destroy($id)) {
            return response()->json([
                'id' => $id,
                'code' => 200,
                'status' => true,
                'message' => "Delete Success",
            ], 200);
        }
        else {

            return response()->json([
                'id' => $id,
                'code' => 404,
                'status' => false,
                'message' => "Delete Fail",
            ], 404);
        }
    }
}
