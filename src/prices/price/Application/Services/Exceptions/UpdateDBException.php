<?php

namespace Src\Prices\Price\Application\Services\Exceptions;

use Src\Prices\Price\Application\Services\Exceptions\UpdatePriceException;

class UpdateDBException extends UpdatePriceException
{
    protected $message = 'Preço não foi atualizado no banco de dados.';
}
