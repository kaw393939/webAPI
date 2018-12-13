<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProfileResource extends Resource
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
            'type'  => 'profiles',
            'id'    => (string)$this->id,
            'attributes' => [
                'user_id' => $this -> user_id,
                'first_name' => $this -> first_name,
                'last_name' => $this -> last_name,
                'bio' => $this -> bio,
            ],
            'relationships' => '',
            'links'         => [
                'self' => route('profiles.show',['profile' => $this->id]),
            ]
        ];
    }
}
