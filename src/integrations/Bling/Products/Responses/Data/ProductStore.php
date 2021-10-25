<?php

namespace Src\Integrations\Bling\Products\Responses\Data;

use Src\Integrations\Bling\Products\Responses\Data\Store;

class ProductStore
{
    private string $sku;
    private Store $store;

    public function __construct(string $sku, Store $store)
    {
        $this->sku = $sku;
        $this->store = $store;
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function getStore(): Store
    {
        return $this->store;
    }
}
