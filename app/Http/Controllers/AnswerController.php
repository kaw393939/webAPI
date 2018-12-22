<?php

	namespace App\Http\Controllers;

use App\Answer;
use App\Events\AnswerEditedEvent;
use App\Events\NewAnswerEvent;
use App\Http\Requests\AnswerCreateRequest;
use App\Http\Requests\AnswerDeleteRequest;
use App\Http\Requests\AnswerUpdateRequest;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\AnswersResource;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;

/**
 * Class AnswerController
 * @package App\Http\Controllers
 */
class AnswerController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return AnswersResource
     */
	public function index()
	{
		return new AnswersResource(AnswerResource::collection(Answer::all()));
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
     *  *  * @SWG\Post (
     *      path = "/questions/{questionId}/answers",
     *      operationId = "create answer for  question with given Id",
     *      tags = {"Answers"},
     *      summary  = "create a  answer ",
     *      description = "Create a an answer for a specific question",

     *
     *
     *
     *
     *     @SWG\Parameter(
     *     name = "questionId",
     *     in = "path",
     *     type = "string",
     *     description = "Id of question",
     *     required =true,
     *     ),
     *

     *          @SWG\Parameter(
     *     name = "Authorization",
     *     in = "header",
     *     type = "string",
     *     description = "Bearer TOKEN",
     *     required =true,
     *
     *     ),
     *     @SWG\Parameter(
     *     name = "answer",
     *     in = "formData",
     *     type = "string",
     *     description = "answer text",
     *     required =true,
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function store(AnswerCreateRequest $request)
	{
		$user = JWTAuth::parseToken()->authenticate();
		$input = $request->only('answer');
		$questionId = $request->route('question');

		try {
			$answer = Answer::create($input);
			$answer->user_id = $user->id;
			$answer->question_id = $questionId;
			$answer->save();

			event(new NewAnswerEvent($answer));

			return response()->json([
				'id' => $answer->id,
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
     * @param  int  $id
     * @return AnswerResource
     */
	public function show(Answer $answer)
	{
		AnswerResource::withoutWrapping();
		return new AnswerResource($answer);
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
     *
     *  /**
     *
     *  * /**
     *
     * @SWG\Put (
     *      path = "/questions/{questionId}/answers/{answerId}",
     *      operationId = "editAnswer",
     *      tags = {"Answers"},
     *      summary  = "Edit an answer for a particular question",
     *      description = "Edit a answer for a particular question",
     *
     *   @SWG\SecurityScheme(
     *         securityDefinition="Bearer",
     *         type="apiKey",
     *         name="Authorization",
     *         in="header"
     *     ),
     * @SWG\Parameter(
     *     name = "questionId",
     *     in = "path",
     *     type = "string",
     *     description = "Id of a given question",
     *     required =true,
     *     ),
     *
     *     @SWG\Parameter(
     *     name = "answerId",
     *     in = "path",
     *     type = "string",
     *     description = "Id of an answer for a given question",
     *     required =true,
     *     ),
     *
     *
     *
     *    @SWG\Parameter(
     *     name = "answer",
     *     in = "formData",
     *     type = "string",
     *     description = "answer text",
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
     *    )
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function update(AnswerUpdateRequest $request)
	{
		$input = $request->only( 'answer');
		$id = $request->route('answer');
		$questionId = $request->route('question');

		try {
			$answer = Answer::where('id', $id)
				->where('question_id', $questionId)
				->first();
			$answer->answer = $input['answer'];
			$answer->save();

			event(new AnswerEditedEvent($answer));

			return response()->json([
				'code' => 200,
				'status' => true,
				'message' => "Answer Updated",
			], 200);
		}
		catch (\Exception $e) {
			return response()->json([
				'code' => 404,
				'status' => true,
				'message' => "Answer Update Failed",
			], 404);
		}
	}

	/**
     *
     * /**
     *
     *  /**
     *
     * * @SWG\Delete (
     *      path = "/questions/{questionId}/answers/{answerId}",
     *      operationId = "deleteAnswer",
     *      tags = {"Answers"},
     *      summary  = "delete an answer for a given question",
     *      description = "Delete an answer for a given question",
     *
     *   @SWG\SecurityScheme(
     *         securityDefinition="Bearer",
     *         type="apiKey",
     *         name="Authorization",
     *         in="header"
     *     ),
     * @SWG\Parameter(
     *     name = "questionId",
     *     in = "path",
     *     type = "string",
     *     description = "question Id",
     *     required =true,
     *     ),
     *
     *
     *  @SWG\Parameter(
     *     name = "answerId",
     *     in = "path",
     *     type = "string",
     *     description = "Answer Id",
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
     *
     *
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function destroy(AnswerDeleteRequest $request)
	{
		$id = $request->route('answer');
		$questionId = $request->route('question');
		$answer = Answer::where('id', $id)
			->where('question_id', $questionId)
			->first();

		if($answer) {
			Answer::destroy($id);
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
