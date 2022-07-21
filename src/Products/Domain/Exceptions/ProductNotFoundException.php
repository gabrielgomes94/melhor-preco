<?php

namespace Src\Products\Domain\Exceptions;

use Exception;

class ProductNotFoundException extends Exception
{
    public readonly string $identifier;

    public function __construct(string $productId, string $userId)
    {
        $this->identifier = $productId;

        parent::__construct("Produto {$productId} não foi encontrado.");
    }
}
