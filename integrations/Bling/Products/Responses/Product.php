<?php

namespace Integrations\Bling\Products\Responses;

use App\Factories\Product\Product as ProductFactory;
use Barrigudinha\Product\Product as ProductData;
use Barrigudinha\Product\Store;

class Product extends BaseResponse
{
    protected ProductData $product;

    public function __construct(array $data = [])
    {
        if (isset($data)) {
            $this->data = ProductFactory::buildFromERP($data);
        }
    }

    public function data(): ProductData
    {
        return $this->data;
    }

    public function product(): ?ProductData
    {
        return $this->data ?? null;
    }

    public function addStores(array $data)
    {
        if (!isset($data['store']) || !$data['store']) {
            return;
        }

        $store = Store::createFromArray($data['store']);

        $this->product->addStore($store);
    }
}
