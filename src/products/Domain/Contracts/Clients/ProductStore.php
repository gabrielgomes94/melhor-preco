<?php

namespace Src\Products\Domain\Contracts\Clients;

use Integrations\Bling\Products\Responses\BaseResponse;

interface ProductStore
{
    /**
     * @param string $sku
     * @param array $stores
     * @return BaseResponse
     */
    public function get(string $sku, ?string $store = null): BaseResponse;

    public function list(int $page = 1, ?string $store = null): BaseResponse;
}

