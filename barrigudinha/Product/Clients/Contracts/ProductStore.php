<?php

namespace Barrigudinha\Product\Clients\Contracts;

use Integrations\Bling\Products\Responses\BaseResponse;

interface ProductStore
{
    /**
     * @param string $sku
     * @param array $stores
     * @return BaseResponse
     */
    public function get(string $sku, array $stores = []): BaseResponse;

    public function list(int $page = 1): BaseResponse;
}