<?php

namespace Integrations\Bling\Products\Responses;

//use Barrigudinha\Product\Product;
use Integrations\Bling\Products\Data\Product;

class ProductIterator extends BaseResponse
{
    /**
     * @param Product[] $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return Product[]
     */
    public function data(): array
    {
        return $this->data;
    }
}
