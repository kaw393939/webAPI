<?php

namespace App\Http\Resources;

use App\Profile;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class ProfilesResource extends ResourceCollection
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
            'data' => ProfileResource::collection($this->collection),
        ];
    }

    public function with($request)
    {

        $profiles = $this->collection->map(
            function($profile) {
                return $profile;
            }
        );
        $included = $profiles->merge($profiles)->unique();
        return [
            'links' => [
                'self' => route('profiles.index'),
            ],
            'included' => $this->withIncluded($included),
        ];
    }

    private function withIncluded(Collection $included)
    {
        return $included->map(
            function ($include) {
                if ($include instanceof Profile){
                    return new ProfileResource($include);
                }
            }
        );
    }
}
