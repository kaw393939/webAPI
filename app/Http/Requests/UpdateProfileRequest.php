<?php

namespace App\Http\Requests;

use App\Profile;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use JWTAuth;

class UpdateProfileRequest extends FormRequest
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
        return $user->id == $this->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required',
            'user_id' => 'required',
            'email' => 'required|email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'bio' => 'required|string',
        ];
    }
}
