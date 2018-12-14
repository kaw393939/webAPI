<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionsResource;
use App\Question;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class QuestionController extends Controller
{
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only( 'user_id', 'question');
        $user = \App\User::findOrFail($input['user_id']);

        try {
            $question = Question::create($input);
            $question->save();
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
    public function update(Request $request, $id)
    {
        $input = $request->only( 'question');

        try {
            $question = \App\Question::findOrFail($id);
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
    public function destroy($id)
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
