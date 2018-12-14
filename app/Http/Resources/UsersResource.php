<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;


class UsersResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => UserResource::collection($this->collection),
        ];
    }


    public function with($request)
    {

        $users = $this->collection->map(
            function($user) {
                return $user;
            }
        );
        $included = $users->merge($users)->unique();
        return [
            'links' => [
                'self' => route('users.index'),
            ],
            'included' => $this->withIncluded($included),
        ];
    }

    private function withIncluded(Collection $included)
    {
        return $included->map(
            function ($include) {
                if ($include instanceof User){
                    return new UserResource($include);
                }
            }
        );
    }

}
