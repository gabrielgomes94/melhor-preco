<?php

namespace Src\Marketplaces\Domain\Exceptions;

use Exception;
use Src\Marketplaces\Domain\Models\Marketplace;

class MarketplaceSlugAlreadyExists extends Exception
{
    public function __construct(Marketplace $marketplace)
    {
        $slug = $marketplace->getSlug();
        $userId = $marketplace->getUserId();
        $message = "Marketplace slug $slug already exists for user $userId";

        parent::__construct($message);
    }
}
