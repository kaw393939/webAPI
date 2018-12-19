<?php

namespace App\Http\Requests;

use App\Answer;
use App\Profile;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use JWTAuth;

class AnswerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function authorize()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $answerId = $this->route('answer');
        $answer = Answer::findOrFail($answerId);
        return $user->id == $answer['user_id'];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'answer' => 'required|string',
        ];
    }
}
