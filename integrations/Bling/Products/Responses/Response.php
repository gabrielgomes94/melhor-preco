<?php

namespace Integrations\Bling\Products\Responses;

use Barrigudinha\Product\Product;
use Barrigudinha\Product\Store;
use Integrations\Bling\Products\Responses\Contracts\Response as ResponseInterface;

class Response implements ResponseInterface
{
    protected ?Product $product = null;
    protected array $errors = [];


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

    public function addStores(array $data)
    {
        if (!isset($data['store']) || !$data['store']) {
            return;
        }

        $store = new Store(
            store_sku_id: $data['store']['skuStoreId'],
            code: $data['store']['code'],
            price: $data['store']['price'],
            promotionalPrice: $data['store']['promotionalPrice'],
            createdAt: $data['store']['createdAt'],
            updatedAt: $data['store']['updatedAt']
        );

        $this->product->addStore($store);
    }
}
