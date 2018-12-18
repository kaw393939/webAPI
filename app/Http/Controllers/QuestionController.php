<?php

namespace App\Http\Controllers;

use App\Events\NewQuestionEvent;
use App\Http\Requests\QuestionCreateRequest;
use App\Http\Requests\QuestionDeleteRequest;
use App\Http\Requests\QuestionEditRequest;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionsResource;
use App\Question;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use JWTAuth;


class QuestionController extends Controller
{
    /**
     *
     * @SWG\Get (
     *      path = "/questions",
     *      operationId = "getQuestions",
     *      tags = {"Questions"},
     *      summary  = "Get list of Questions",
     *      description = "return list of questions",
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
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return new QuestionsResource(QuestionResource::collection(Question::all()));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }
    /**
     *
     *  /**
     * @SWG\Get (
     *      path = "/questions/{id}",
     *      operationId = "getQuestionById",
     *      tags = {"Question"},
     *      summary  = "Get question info",
     *      description = "return question data",
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
     *
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionCreateRequest $request)
    {
        $input = $request->only( 'question');
        $user = JWTAuth::toUser($request->bearerToken());

        try {
            $question = Question::create($input);
            $question->user_id = $user->id;
            $question->save();

            event(new NewQuestionEvent($question));

            return response()->json([
                'id' => $question->id,
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
     * @param  Question $question
     * @return \App\Http\Resources\QuestionResource
     */
    public function show(Question $question)
    {
        QuestionResource::withoutWrapping();
        return new QuestionResource($question);
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
    public function update(QuestionEditRequest $request, $id)
    {
        $input = $request->only( 'question');

        try {
            $question = Question::findOrFail($id);
            $question->question = $input['question'];
            $question->save();

            return response()->json([
                'id' => $id,
                'code' => 200,
                'status' => true,
                'message' => "Update Success",
            ], 200);
        }
        catch (\Exception $exception) {
            return response()->json([
                'id' => $id,
                'code' => 404,
                'status' => false,
                'message' => "Update Fail",
            ], 404);
        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionDeleteRequest $request, $id)
    {

        if(Question::destroy($id)) {
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
