<?php

namespace Src\Prices\Application\Services\Exceptions;

use Src\Prices\Application\Services\Exceptions\UpdatePriceException;

class UpdateDBException extends UpdatePriceException
{
    protected $message = 'Preço não foi atualizado no banco de dados.';
}
