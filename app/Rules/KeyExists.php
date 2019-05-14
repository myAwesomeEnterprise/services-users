<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class KeyExists implements Rule
{
    protected $table;
    protected $column;

    /**
     * Create a new rule instance.
     *
     * @param  string $tableName
     * @param  string $columnName
     * @return void
     */
    public function __construct($tableName, $columnName = 'id')
    {
        $this->table = $tableName;
        $this->column = $columnName;
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
        $ids = array_keys($value);
        $matches = DB::table($this->table)->whereIn($this->column, $ids)->count();

        return count($ids) === $matches;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.key_exists');
    }
}
