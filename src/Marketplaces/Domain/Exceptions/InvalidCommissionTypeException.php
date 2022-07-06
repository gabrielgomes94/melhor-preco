<?php

namespace Src\Marketplaces\Domain\Exceptions;

use InvalidArgumentException;

class InvalidCommissionTypeException extends InvalidArgumentException
{
    public function __construct(string $type)
    {
        $message = "Commission type $type is invalid.";

        parent::__construct($message);
    }
}
