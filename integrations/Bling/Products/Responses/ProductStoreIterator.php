<?php

namespace Integrations\Bling\Products\Responses;

use Barrigudinha\Product\Product as ProductData;

class ProductStoreIterator extends BaseResponse
{
    /**
     * @return ProductData[]
     */
    public function data(): array
    {
        return $this->data;
    }
}
