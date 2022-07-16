<?php

namespace Src\Marketplaces\Domain\Exceptions;

use Exception;

class MarketplaceNotFoundException extends Exception
{
    public readonly string $identifier;

    public function __construct(string $identifier)
    {
        $this->identifier = $identifier;
        $message = "Marketplaces {$identifier} not found";

        parent::__construct($message);
    }
}
