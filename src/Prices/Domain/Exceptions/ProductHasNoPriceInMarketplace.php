<?php

namespace Src\Prices\Domain\Exceptions;

use Exception;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Products\Domain\Models\Product;

class ProductHasNoPriceInMarketplace extends Exception
{
    public function __construct(Product $product, Marketplace $marketplace)
    {
        $sku = $product->getSku();
        $slug = $marketplace->getSlug();
        $message = "Product with SKU $sku not found in marketplace $slug";

        parent::__construct($message);
    }
}
