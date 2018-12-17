<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class AnswerResource extends resource
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
            'id'=> (string) $this->id,
            'author' =>[
                'firstName'=>'',
                'lastName'=>'',
                'avatar'=>'',
            ],
            'text'=> (string) $this->answer,
            'createdAt'=>$this->created_at,
        ];
    }
}
