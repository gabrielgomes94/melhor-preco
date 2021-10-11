<?php

namespace Src\Prices\Infrastructure\Repositories\Product;

use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
use Src\Prices\Infrastructure\Repositories\Product\Filters\Active;
use Src\Prices\Infrastructure\Repositories\Product\Filters\Contracts\Filter;
use Src\Prices\Infrastructure\Repositories\Product\Filters\MarginRange;
use Src\Prices\Infrastructure\Repositories\Product\Queries\CompositionProducts as QueryCompositionProducts;
use Src\Prices\Infrastructure\Repositories\Product\Queries\Products as QueryProducts;
use Src\Prices\Infrastructure\Repositories\Product\Queries\ProductsBySku as QueryProductsBySku;
use Src\Products\Infrastructure\Repositories\BaseList;
use Barrigudinha\Product\Entities\ProductsCollection;
use Barrigudinha\Product\Utils\Contracts\Options;

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
