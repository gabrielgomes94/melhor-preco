<?php

namespace Barrigudinha\Pricing\PriceList;

use Barrigudinha\Product\Product;

class PriceList
{
    private string $id;
    private string $name;

    /** @var Product[]
     */
    private array $products;

    /** @var string[]  */
    private array $stores;

    public function __construct(string $id, string $name, array $products, array $stores)
    {
        $this->id = $id;
        $this->name = $name;
        $this->products = $products;
        $this->stores = $stores;
    }

    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return Product[]
     */
    public function products(): array
    {
        return $this->products;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function stores(): array
    {
        return $this->stores;
    }
}
