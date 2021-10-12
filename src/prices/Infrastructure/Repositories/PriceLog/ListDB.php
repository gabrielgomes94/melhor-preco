<?php

namespace Src\Prices\Infrastructure\Repositories\PriceLog;

use Src\Prices\Application\Factories\PriceLog\PriceLog;
use Src\Products\Domain\Models\Product as ProductModel;
use Src\Products\Infrastructure\Repositories\BaseList;
use Src\Products\Domain\Entities\ProductsCollection;
use Src\Products\Domain\Contracts\Utils\Options;
use Illuminate\Database\Eloquent\Builder;

class ListDB extends BaseList
{
    public function count(Options $options): int
    {
        return $this->query($options)->count();
    }

    protected function get(?Options $options = null): array
    {
        return $this->query($options)
            ->paginate(perPage: $options->perPage(), page: $options->page())
            ->items();
    }

    protected function map(array $products, Options $options): ProductsCollection
    {
        $products = array_map(function (ProductModel $product) {
            return PriceLog::buildProduct($product);
        }, $products);

        return new ProductsCollection($products);
    }

    private function query(Options $options): Builder
    {
        return ProductModel::leftJoin('prices', 'prices.product_id', '=', 'products.id')
            ->whereNull('parent_sku')
            ->where('is_active', true)
            ->where('prices.store', $options->store())
            ->orderBy('prices.updated_at', 'desc');
    }
}
