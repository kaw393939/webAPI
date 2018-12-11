<?php

namespace App\Http\Requests;

use App\Profile;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class EditUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(User $user, Profile $profile)
    {
        if($user->id == $profile->user_id) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'name' => 'required|string',
            'email' => 'required|string',
            'bio' => 'required|string',

        ];
    }
}
