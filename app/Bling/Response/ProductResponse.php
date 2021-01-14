<?php
namespace App\Bling\Response;

use App\Bling\Data\Product;

class ProductResponse
{
    /**
     * @var string[]
     */
    private $errors = [];

    /**
     * @var Product[]
     */
    private $products = [];


    public function __construct(array $data)
    {
        $this->fill($data);
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
        return [
            'errors' => $this->errors,
            'products' => $products,
        ];
    }
}
