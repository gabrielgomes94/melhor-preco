<?php

namespace App\Repositories\Product;

use App\Repositories\Pricing\Product\Filters\Contracts\Filter;
use App\Repositories\Product\Options\Options;
use Barrigudinha\Product\Entities\ProductsCollection;
use Barrigudinha\Product\Repositories\Contracts\ListProducts;
use Barrigudinha\Product\Repositories\Contracts\Options as OptionsInterface;

abstract class BaseList implements ListProducts
{
    protected array $filters = [];

    public abstract function count(?OptionsInterface $options = null): int;
    protected abstract function get(?Options $options = null): array;
    protected abstract function map(array $products, Options $options): ProductsCollection;

    public function all(): ProductsCollection
    {
        $products = $this->get();

        return new ProductsCollection($products);
    }

    public function list(?OptionsInterface $options = null): ProductsCollection
    {
        if (!$options) {
            $options = new Options(['page' => 1]);
        }

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
