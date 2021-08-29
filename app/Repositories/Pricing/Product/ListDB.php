<?php

namespace App\Repositories\Pricing\Product;

use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
use App\Repositories\Pricing\Product\Filters\Active;
use App\Repositories\Pricing\Product\Filters\Contracts\Filter;
use App\Repositories\Pricing\Product\Filters\Kit;
use App\Repositories\Pricing\Product\Filters\MarginRange;
use App\Repositories\Pricing\Product\Queries\CompositionProducts as QueryCompositionProducts;
use App\Repositories\Pricing\Product\Queries\Products as QueryProducts;
use App\Repositories\Pricing\Product\Queries\ProductsBySku as QueryProductsBySku;
use App\Repositories\Product\BaseList;
use Barrigudinha\Product\Entities\ProductsCollection;
use Barrigudinha\Product\Utils\Contracts\Options;
use Illuminate\Database\Eloquent\Builder;

class ListDB extends BaseList
{
    /**
     * @var Filter[] $filters
     */
    protected array $filters = [
        Active::class,
        MarginRange::class,
    ];

    public function count(?Options $options = null): int
    {
        if (!$options) {
            return 0;
        }

        if ($options->sku()) {
            return QueryProductsBySku::count($options);
        }

        if ($options->shouldFilterKits()) {
            return QueryCompositionProducts::count($options);
        }

        return QueryProducts::count($options);
    }

    protected function get(?Options $options = null): array
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
