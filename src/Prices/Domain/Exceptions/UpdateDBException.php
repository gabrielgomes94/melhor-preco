<?php

namespace Src\Prices\Domain\Exceptions;

use Src\Prices\Domain\Exceptions\UpdatePriceException;

class UpdateDBException extends UpdatePriceException
{
    protected $message = 'Preço não foi atualizado no banco de dados.';
}
