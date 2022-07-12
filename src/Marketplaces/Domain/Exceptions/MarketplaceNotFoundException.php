<?php

namespace Src\Marketplaces\Domain\Exceptions;

use Exception;

class MarketplaceNotFoundException extends Exception
{
    public function __construct(string $identifier)
    {
        $message = "Marketplaces {$identifier} not found";

        parent::__construct($message);
    }
}
