<?php

namespace Barrigudinha\Product\Clients\Contracts;

use Integrations\Bling\Products\Responses\BaseResponse;

interface ProductStore
{
    public function get(string $sku, array $stores = []): BaseResponse;

    public function list(int $page = 1): BaseResponse;
}
