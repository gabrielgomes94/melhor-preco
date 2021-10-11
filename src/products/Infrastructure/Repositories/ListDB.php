<?php

namespace Src\Products\Infrastructure\Repositories;

use App\Factories\Product\Product as ProductFactory;
use App\Models\Product as ProductModel;
use Src\Prices\Infrastructure\Repositories\Product\Filters\Active;
use Src\Prices\Infrastructure\Repositories\Product\Filters\Contracts\Filter;
use Src\Prices\Infrastructure\Repositories\Queries\Products as QueryProducts;
use Src\Prices\Infrastructure\Repositories\Queries\ProductsBySku as QueryProductsBySku;
use Barrigudinha\Product\Entities\ProductsCollection;
use Barrigudinha\Product\Utils\Contracts\Options;
use Src\Products\Infrastructure\Repositories\BaseList;

class ListDB extends BaseList
{
    /**
     * @var Filter[] $filters
     */
    protected array $filters = [
        Active::class,
    ];

    protected function get(Options $options): array
    {
        if (!$options->page()) {
            return QueryProducts::query($options)->get()->all();
        }

        if ($options->sku()) {
            return QueryProductsBySku::paginate($options);
        }

        return QueryProducts::paginate($options);
    }

    public function count(Options $options): int
    {
        if ($options->sku()) {
            return QueryProductsBySku::count($options);
        }

        return QueryProducts::count($options);
    }

    protected function map(array $products, Options $options): ProductsCollection
    {
        $products = array_map(function (ProductModel $product) {
            return ProductFactory::buildFromModel($product);
        }, $products);

        return new ProductsCollection($products);
    }
}
