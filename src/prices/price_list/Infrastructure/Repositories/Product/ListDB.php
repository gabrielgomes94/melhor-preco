<?php

namespace Src\Prices\PriceList\Infrastructure\Repositories\Product;

use Src\Products\Application\Factories\Product as ProductFactory;
use Src\Products\Domain\Models\Product as ProductModel;
use Src\Prices\PriceList\Infrastructure\Repositories\Product\Filters\Active;
use Src\Prices\PriceList\Infrastructure\Repositories\Product\Filters\Contracts\Filter;
use Src\Prices\PriceList\Infrastructure\Repositories\Product\Filters\MarginRange;
use Src\Prices\PriceList\Infrastructure\Repositories\Product\Queries\CompositionProducts as QueryCompositionProducts;
use Src\Prices\PriceList\Infrastructure\Repositories\Product\Queries\Products as QueryProducts;
use Src\Prices\PriceList\Infrastructure\Repositories\Product\Queries\ProductsBySku as QueryProductsBySku;
use Src\Products\Infrastructure\Repositories\BaseList;
use Src\Products\Domain\Entities\ProductsCollection;
use Src\Products\Domain\Contracts\Utils\Options;

class ListDB extends BaseList
{
    /**
     * @var Filter[] $filters
     */
    protected array $filters = [
        Active::class,
        MarginRange::class,
    ];

    public function count(Options $options): int
    {
        if ($options->sku()) {
            return QueryProductsBySku::count($options);
        }

        if ($options->shouldFilterKits()) {
            return QueryCompositionProducts::count($options);
        }

        return QueryProducts::count($options);
    }

    protected function get(Options $options): array
    {
        if ($options->sku()) {
            return QueryProductsBySku::paginate($options);
        }

        if ($options->shouldFilterKits()) {
            return QueryCompositionProducts::paginate($options);
        }

        return QueryProducts::paginate($options);
    }

    protected function map(array $products, Options $options): ProductsCollection
    {
        $products = array_map(function (ProductModel $product) {
            return ProductFactory::buildWithPrice($product);
        }, $products);

        return new ProductsCollection($products);
    }
}
