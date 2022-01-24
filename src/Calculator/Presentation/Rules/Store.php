<?php

namespace Src\Calculator\Presentation\Rules;

use Illuminate\Contracts\Validation\Rule;

class Store implements Rule
{
    /**
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        $stores = array_keys(config('stores'));

        return in_array($value, $stores);
    }

    public function message(): string
    {
        return 'O campo loja é invalido.';
    }
}
