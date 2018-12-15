<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
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
        return [
            'id'    => (string)$this->id,
            'author' =>[
                'firstName'=>'',
                'lastName'=>'',
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
            'answers'=> [
                [
                    'id'=>'',
                    'author' =>[
                        'firstName'=>'',
                        'lastName'=>'',
                        'avatar'=>'',
                    ],
                    'text'=>'',
                    'createdAt'=>'',
                ]
            ],

//            'relationships' => '',
//            'links'         => [
//                'self' => route('questions.show',['question' => $this->id]),
//            ]
        ];
    }
}
