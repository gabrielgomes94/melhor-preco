<?php

namespace Barrigudinha\Pricing\Data;

/*
 * To Do: renomear essa classe para PriceList
 */
class Pricing
{
    public string $id;

    public string $name;

    /**
     * @var Product[] $products
     */
    public array $products;

    public array $stores;

    public function __construct(string $name, array $products, array $stores, ?string $id = null)
    {
        $this->id = $id ?? '';
        $this->name = $name;
        $this->products = $products;
        $this->stores = $stores;
    }
}
