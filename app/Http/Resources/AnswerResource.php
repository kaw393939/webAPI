<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class AnswerResource extends Resource
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

        return [
            'id'=> (string) $this->id,
            'author' =>[
                'firstName'=>$profile->first_name,
                'lastName'=>$profile->last_name,
                'avatar'=>'',
            ],
            'text'=> (string) $this->answer,
            'createdAt'=>$this->created_at,
        ];
    }
}
