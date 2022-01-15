<?php

namespace Src\Products\Application\Exceptions;

use Exception;

class ProductNotFoundException extends Exception
{
    private string $productId;

    public function __construct(string $productId)
    {
        parent::__construct("Produto {$productId} não foi encontrado.");
    }

}
