<?php

namespace App\Http\Resources;

use App\Answer;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class AnswersResource extends ResourceCollection
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
            AnswerResource::collection($this->collection),
        ];
    }


    public function with($request)
    {

        $answers = $this->collection->map(
            function($answer) {
                return $answer;
            }
        );
        $included = $answers->merge($answers)->unique();
        return [
            'links' => [
                'self' => route('answers.index'),
            ],
            'included' => $this->withIncluded($included),
        ];
    }

    private function withIncluded(Collection $included)
    {
        return $included->map(
            function ($include) {
                if ($include instanceof Answer){
                    return new AnswerResource($include);
                }
            }
        );
    }
}
