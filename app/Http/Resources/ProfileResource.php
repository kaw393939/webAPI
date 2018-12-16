<?php

namespace App\Http\Resources;

use App\User;
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
            'id'    => (string)$this->id,
            'user_id' => $this -> user_id,
            'email' => User::find($this -> user_id)['email'],
            'first_name' => $this -> first_name,
            'last_name' => $this -> last_name,
            'bio' => $this -> bio,
            'created_at' => $this -> created_at,
        ];
    }
}
