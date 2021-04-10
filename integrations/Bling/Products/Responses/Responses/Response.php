<?php

namespace Integrations\Bling\Products\Responses\Responses;

use Barrigudinha\Product\Product;
use Integrations\Bling\Products\Responses\Responses\Contracts\Response as ResponseInterface;

class Response implements ResponseInterface
{
    protected ?Product $product = null;
    protected array $errors = [];
    /**
     * Store[] array
     */
    public array $stores = [];

    public function addErrors(string $error){
        $this->errors[] = $error;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function product(): ?Product
    {
        return $this->product;
    }

    public function addStores(array $store)
    {
        $this->stores[] = $store;
    }
}
