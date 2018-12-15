<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JWTAuth;

class QuestionDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $questionId = $this->route('question');
        $question = \App\Question::findorfail($questionId);
        return $user->id == $question->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
