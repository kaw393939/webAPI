<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class QuestionResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = \App\User::findOrFail($this->user_id);
        $profile = \App\Profile::findOrFail($user->id);
        $answers = \App\Answer::where('question_id', $this->id)->get();

        return [
            'id'    => (string)$this->id,
            'author' =>[
                'firstName'=>$profile->first_name,
                'lastName'=>$profile->last_name,
                'avatar'=>''
            ],

            'text' => (string)$this->question,
//            'relationships' => new UsersRelationshipResource($this),
            'tags'=>[
                [
                    'id'=>'',
                    'title'=>''
                ]
            ],
            'createdAt'=>$this->created_at,
            'likes'=>'',
            'votes'=>'',
//           ANSWERS OBJECT CAN GO HERE
            'answers'=> AnswerResource::collection($answers),
//                'data' => new AnswersResource(AnswerResource::collection($answers)),
//                [
//                    'id'=>'',
//                    'author' =>[
//                        'firstName'=>'',
//                        'lastName'=>'',
//                        'avatar'=>'',
//                    ],
//                    'text'=>'',
//                    'createdAt'=>'',
//                ]


//            'relationships' => '',
//            'links'         => [
//                'self' => route('questions.show',['question' => $this->id]),
//            ]
        ];
    }
}
