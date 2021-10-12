<?php

namespace Integrations\Bling\Products\Responses;

use Src\Products\Domain\Entities\Product as ProductData;
use Src\Products\Domain\Entities\Product;

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
