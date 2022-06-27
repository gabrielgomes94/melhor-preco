<?php

namespace Src\Prices\Domain\Exceptions;

use Src\Prices\Domain\Exceptions\UpdatePriceException;

// @deprecated
class ProductNotFound extends UpdatePriceException
{
    protected $message = 'Produto não foi encontrado no banco de dados.';
}
