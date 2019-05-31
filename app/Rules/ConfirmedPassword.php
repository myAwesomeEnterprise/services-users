<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ConfirmedPassword implements Rule
{
    protected $user_id;
    protected $table;
    protected $id_column;
    protected $password_column;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($user_id, $table = 'users', $password_column = 'password', $id_column = "id")
    {
        $this->user_id = $user_id;
        $this->table = $table;
        $this->id_column = $id_column;
        $this->password_column = $password_column;
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
        $user = DB::table($this->table)
            ->where($this->id_column, $this->user_id)
            ->first();

        if (!$user) {
            return false;
        }

        $password_column = $this->password_column;

        return Hash::check($value, $user->$password_column);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.confirmed_password');
    }
}
