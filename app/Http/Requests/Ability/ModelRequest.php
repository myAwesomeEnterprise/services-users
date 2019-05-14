<?php

namespace App\Http\Requests\Ability;

use Illuminate\Foundation\Http\FormRequest;

class ModelRequest extends FormRequest
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
            'user'    => 'required|exists:users,uuid',
            'ability' => 'required|exists:abilities,name',
            'model'   => 'required',
            'allow'   => 'required|boolean',
            'forbid'  => 'required|boolean',
        ];
    }
}
