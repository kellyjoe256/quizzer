<?php

namespace App\Rules;

use DB;
use Illuminate\Contracts\Validation\Rule;

class IUnique implements Rule
{
    protected $id;

    protected $table;

    protected $bindings;

    protected $messageKey;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        $table,
        $messageKey,
        array $bindings,
        $id = null
    ) {
        $this->table = $table;
        $this->messageKey = $messageKey;
        $this->bindings = $bindings;
        $this->id = $id;
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
        return $this->check();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "{$this->messageKey} is already taken";
    }

    protected function check()
    {
        $query = DB::table($this->table);

        foreach ($this->bindings as $column => $value) {
            if (!$value) {
                continue;
            }

            if (is_numeric($value)) {
                $query->whereRaw("{$column} = ?", $value);
            } else {
                $query->whereRaw("LOWER({$column}) = LOWER(?)", $value);
            }
        }

        if ($this->id) {
            $query->whereRaw("id <> ?", [$this->id]);
        }

        return !$query->count();
    }
}
