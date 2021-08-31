<?php

namespace App\Repositories\Product;

use App\Http\Requests\Utils\ProductOptions;
use App\Repositories\Pricing\Product\Filters\Contracts\Filter;
use Barrigudinha\Product\Entities\ProductsCollection;
use Barrigudinha\Product\Repositories\Contracts\ListProducts;
use Barrigudinha\Product\Utils\Contracts\Options;

abstract class BaseList implements ListProducts
{
    protected array $filters = [];

    public abstract function count(Options $options): int;
    protected abstract function get(Options $options): array;
    protected abstract function map(array $products, Options $options): ProductsCollection;

    public function all(): ProductsCollection
    {
        $options = new ProductOptions([]);
        $products = $this->get($options);

        return $this->map($products, $options);
    }

    public function list(Options $options): ProductsCollection
    {
        $products = $this->get($options);
        $products = $this->map($products, $options);
        return $this->filterProducts($products, $options);
    }

    private function filterProducts(ProductsCollection $products, Options $options): ProductsCollection
    {
        /**
         * @var Filter $filter
         */
        foreach ($this->filters as $filter) {
            $products = $filter::execute($products, $options);
        }

        return $products ?? new ProductsCollection([]);
    }
}
