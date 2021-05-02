<?php

namespace Integrations\Bling\Products\Responses;

use Barrigudinha\Product\Product as ProductData;

class ProductResponse extends Response
{
    public function __construct(array $data = [])
    {
        if (isset($data['product'])) {
            $this->product = ProductData::createFromArray($data['product']);
        }
    }
}
