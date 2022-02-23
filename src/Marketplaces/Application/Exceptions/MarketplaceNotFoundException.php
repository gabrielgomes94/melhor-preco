<?php

namespace Src\Marketplaces\Application\Exceptions;

use Exception;

class MarketplaceNotFoundException extends Exception
{
    public function __construct(string $identifier)
    {
        $message = "Marketplace {$identifier} not found";

        parent::__construct($message);
    }
}
