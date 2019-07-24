<?php

namespace App\Http\Requests\User;

use App\Rules\ConfirmedPassword;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current_password' => ['required', new ConfirmedPassword($this->route('user')->id)],
            'password'         => 'required|max:255|confirmed'
        ];
    }
}
