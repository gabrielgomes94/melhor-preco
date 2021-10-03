<?php

namespace Src\Prices\Application\Services\UpdatePrice\Exceptions;

use Src\Prices\Application\Services\UpdatePrice\Exceptions\UpdatePriceException;

class UpdateDBException extends UpdatePriceException
{
    protected $message = 'Preço não foi atualizado no banco de dados.';
}
