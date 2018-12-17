<?php

namespace App\Http\Resources;

use App\Question;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class QuestionsResource extends ResourceCollection
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
            'data' => QuestionResource::collection($this->collection),
        ];
    }
    public function with($request)
    {
        $questions = $this->collection->map(
            function($question) {
                return $question;
            }
        );
        $included = $questions->merge($questions)->unique();
        return [
            'links' => [
                'self' => route('questions.index'),
            ],
            'included' => $this->withIncluded($included),
        ];
    }
    private function withIncluded(Collection $included)
    {
        return $included->map(
            function ($include) {
                if ($include instanceof Question){
                    return new QuestionResource($include);
                }
            }
        );
    }
}
