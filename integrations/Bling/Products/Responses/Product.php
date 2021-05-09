<?php

namespace Integrations\Bling\Products\Responses;

use Barrigudinha\Product\Product as ProductData;
use Barrigudinha\Product\Store;

class Product extends BaseResponse
{
    protected ProductData $product;

    public function __construct(array $data = [])
    {
        if (isset($data['product'])) {
            $this->data = ProductData::createFromArray($data['product']);
        }
    }

    public function data(): ProductData
    {
        return $this->data;
    }

    public function product(): ProductData
    {
        return $this->data;
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
