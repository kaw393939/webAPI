<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;
class UserController extends Controller
{
    /**
     *
     * @SWG\Get (
     *      path = "/users",
     *      operationId = "getUsers",
     *      tags = {"Users"},
     *      summary  = "Get list of users",
     *      description = "return list of users",
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
    public function index()
    {

        return new UsersResource(UserResource::collection(User::all()));
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
     * @SWG\Get (
     *      path = "/users/{id}",
     *      operationId = "getUserById",
     *      tags = {"Users"},
     *      summary  = "Get user info",
     *      description = "return user data",
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
     * Display the specified resource.
     *
     * @param  User $user
     * @return \App\Http\Resources\UserResource
     */
    public function show(User $user)
    {
        UserResource::withoutWrapping();
        return new UserResource($user);
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
    public function update(Request $request, $id)
    {
        //
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
