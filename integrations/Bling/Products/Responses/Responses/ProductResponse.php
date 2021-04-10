<?php

namespace Integrations\Bling\Products\Responses\Responses;

use Barrigudinha\Product\Product as ProductData;
use Integrations\Bling\Products\Responses\Contracts\Response as ProductResponseInterface;

class ProductResponse extends Response
{
    public function __construct(array $data = [])
    {
        if (isset($data['product'])) {
            $this->product = ProductData::createFromArray($data['product']);
        }
    }
}
