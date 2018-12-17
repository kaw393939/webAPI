<?php

namespace App\Http\Resources;

use App\Answer;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class AnswersResources extends resource
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
            'data' => QuestionResource::collection($this->collection),
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
 //               'self' => route('answers.index'),
                'self' => '',
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
