<?php
namespace App\Bling\Product\Response;

use App\Barrigudinha\Product\Product;

/**
 * @deprecated
 * Quando passarmos a usar o cliente novo para integração no Bling, essa classe será desnecessária
 */
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

    /**
     * @var Product
     */
    private $product;


    public function __construct(?array $data, $error = null)
    {
        if (!empty($data)) {
            $this->fill($data);
        }

        if (!empty($error)) {
            $this->errors[] = $error;
        }
    }

    private function fill(array $data): void
    {
        $products = $data['data']['products'] ?? [];

        foreach($products as $product) {
            $this->products[] = new Product($product);
        }

        $this->product = new Product($products[0]);
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

    public function product(): Product
    {
        return $this->product;
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
