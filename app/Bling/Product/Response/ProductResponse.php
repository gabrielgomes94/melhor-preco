<?php
namespace App\Bling\Product\Response;

use App\Barrigudinha\Product\Product;

class ProductResponse
{
    /**
     * @var ?array
     */
    private $errors = [];

    /**
     * @var Product[]
     */
    private $products = [];


    public function __construct(?array $data, ?array $error = null)
    {
        if (!empty($data)) {
            $this->fill($data);
        }

        if (!empty($error)) {
            $this->errors = $error;
        }
    }

    private function fill(array $data): void
    {
        $products = $data['data']['products'] ?? [];

        foreach($products as $product) {
            $this->products[] = new Product($product);
        }
    }

    public function toArray(): array
    {
        $products = [];
        foreach($this->products as $product) {
            $products[] = $product->toArray();
        }

        return $products;
    }

    public function errors(): ?array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function hasData(): bool
    {
        return !empty($this->products);
    }
}
