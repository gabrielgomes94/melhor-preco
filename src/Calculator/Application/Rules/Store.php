<?php

namespace Src\Calculator\Application\Rules;

use Illuminate\Contracts\Validation\Rule;

class Store implements Rule
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
        $stores = array_keys(config('stores'));

        return in_array($value, $stores);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O campo loja é invalido.';
    }
}
