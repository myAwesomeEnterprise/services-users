<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Hexadecimal implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^#[a-f0-9]{6}$/i', $value) || preg_match('/^#[a-f0-9]{3}$/i', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a hexadecimal value.';
    }
}
