<?php

namespace Src\Products\Infrastructure\Repositories;

use App\Http\Requests\Utils\ProductOptions;
use Src\Prices\Infrastructure\Repositories\Product\Filters\Contracts\Filter;
use Src\Products\Domain\Entities\ProductsCollection;
use Src\Products\Domain\Contracts\Repositories\ListProducts;
use Src\Products\Domain\Contracts\Utils\Options;

abstract class BaseList implements ListProducts
{
    protected array $filters = [];

    abstract public function count(Options $options): int;
    abstract protected function get(Options $options): array;
    abstract protected function map(array $products, Options $options): ProductsCollection;

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
         * @var \Src\Prices\Infrastructure\Repositories\Product\Filters\Contracts\Filter $filter
         */
        foreach ($this->filters as $filter) {
            $products = $filter::execute($products, $options);
        }

        return $products ?? new ProductsCollection([]);
    }
}
