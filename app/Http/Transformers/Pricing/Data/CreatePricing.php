<?php

namespace App\Http\Transformers\Pricing\Data;

use Barrigudinha\Pricing\Data\Contracts\CreatePricing as CreatePricingInterface;

class CreatePricing implements CreatePricingInterface
{
    private string $name;
    private array $products;
    private array $stores;

    public function __construct(string $name, array $products, array $stores)
    {
        $this->name = $name;
        $this->products = $products;
        $this->stores = $stores;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function skuList(): array
    {
        return $this->products;
    }

    public function stores(): array
    {
        return $this->stores;
    }
}
