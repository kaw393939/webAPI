<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
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
            'type'  => 'users',
            'id'    => (string)$this->id,
            'attributes' => [
                'name' => $this -> name,
                'email' => $this -> email,
                'email_verified_at' => $this->email_verified_at,
            ]
        ];
    }
}
