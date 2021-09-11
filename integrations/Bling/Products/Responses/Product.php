<?php

namespace Integrations\Bling\Products\Responses;

use Integrations\Bling\Products\Responses\Data\Product as ProductData;
use Barrigudinha\Product\Data\Store;

class Product extends BaseResponse
{
    protected ProductData $product;

    public function __construct(ProductData $data)
    {
        $this->data = $data;
    }

    public function data(): ProductData
    {
        return $this->data;
    }

    /**
     * @deprecated
     */
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
