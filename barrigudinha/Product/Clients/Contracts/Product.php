<?php

namespace Barrigudinha\Product\Clients\Contracts;

use Integrations\Bling\Products\Responses\BaseResponse;

interface Product
{
    public function get(string $sku): BaseResponse;
}
