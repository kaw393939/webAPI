<?php

namespace App\Http\Requests;

use App\Profile;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use JWTAuth;

/**
 * Class ProfileDeleteRequest
 * @package App\Http\Requests
 */
class ProfileDeleteRequest extends FormRequest
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
        $profileId = $this->route('profile');
        $profile = Profile::findOrFail($profileId);
        return $user->id == $profile['user_id'];
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
