<?php

namespace Src\Prices\Price\Application\Services\Products;

use Src\Products\Domain\Utils\Contracts\Options;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Products\Domain\Models\Product\Product;

class ListProducts
{
    public function listPaginate(Options $options): LengthAwarePaginator
    {
        $page = $options->page();
        $store = $options->store();

        if ($options->sku()) {
            return Product::listProductsBySku(
                $store,
                $options->sku(),
                $page
            );
        }

        if ($options->shouldFilterKits()) {
            return Product::listCompositionProducts(
                $store,
                $page
            );
        }

        return Product::listProducts($store, $page);
    }
}
