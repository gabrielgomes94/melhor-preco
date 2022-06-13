<?php

namespace Src\Users\Infrastructure\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use Src\Users\Domain\UseCases\ValidateDocuments;

class FiscalId implements Rule
{
    public function passes($attribute, $value): bool
    {
        if (ValidateDocuments::validateCPF($value)) {
            return true;
        }

        if (ValidateDocuments::validateCNPJ($value)) {
            return true;
        }

        return false;
    }

    public function message(): string
    {
        return 'O campo deve ser um CPF ou CNPJ válido.';
    }
}
