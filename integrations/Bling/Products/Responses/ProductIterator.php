<?php

namespace Integrations\Bling\Products\Responses;

use Barrigudinha\Product\Product as ProductData;

class ProductIterator extends BaseResponse
{
    public function __construct(array $data)
    {
        $this->data= [];

        if (isset($data)) {
            $this->data = array_map(
                function(array $product){
                    return ProductData::createFromArray($product);
                },
                $data
            );
        }
    }

    /**
     * @return ProductData[]
     */
    public function data(): array
    {
        return $this->data;
    }
}
