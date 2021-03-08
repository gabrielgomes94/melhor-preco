<?php

namespace App\Http\Transformers\Pricing\Data;

use Spatie\DataTransferObject\DataTransferObject;

class Campaign extends DataTransferObject
{
    public string $name;

    public array $products;

    public function __construct(string $name, array $products)
    {
        $this->name = $name;
        $this->products = $products;
    }

    public function skuList(): string
    {
        return implode(',', $this->products);
    }
}
