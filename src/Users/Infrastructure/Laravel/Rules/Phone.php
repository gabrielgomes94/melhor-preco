<?php

namespace Src\Users\Infrastructure\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;

class Phone implements Rule
{
    public function passes($attribute, $value): bool
    {
        return (bool) preg_match('/^\+\d{12,13}$/', $value);
    }

    public function message(): string
    {
        return 'O campo deve ser um telefone no formato válido.';
    }
}
