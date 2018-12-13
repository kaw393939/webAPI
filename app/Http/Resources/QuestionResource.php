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
            'type'  => 'questions',
            'id'    => (string)$this->id,
            'text' => (string)$this->question,
//            'relationships' => new UsersRelationshipResource($this),
            'relationships' => '',
            'links'         => [
                'self' => route('questions.show',['question' => $this->id]),
            ]
        ];
    }
}
