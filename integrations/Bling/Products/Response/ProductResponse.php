<?php

namespace Integrations\Bling\Products\Response;

use Barrigudinha\Product\Product as ProductData;
use Integrations\Bling\Products\Response\Contracts\ProductResponse as ProductResponseInterface;

class ProductResponse implements ProductResponseInterface
{
    private array $errors = [];
    private ?ProductData $product = null;

    public function __construct(array $data = [], ?string $error = null)
    {
        $this->setErrors($data, $error);
        $this->setProduct($data);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function product(): ?ProductData
    {
        return $this->product;
    }

    private function setErrors(array $data, ?string $error): void
    {
        if (isset($error)) {
            $this->errors[] = $error;
        }

        if (isset($data['error'])) {
            $this->errors[] = $data['error']['msg'];
        }
    }

    private function setProduct(array $data): void
    {
        if (isset($data['product'])) {
            $this->product = ProductData::createFromArray($data['product']);
        }
    }
}
