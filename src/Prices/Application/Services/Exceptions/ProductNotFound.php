<?php

namespace Src\Prices\Application\Services\Exceptions;

use Src\Prices\Application\Services\Exceptions\UpdatePriceException;

class ProductNotFound extends UpdatePriceException
{
    protected $message = 'Produto não foi encontrado no banco de dados.';
}
