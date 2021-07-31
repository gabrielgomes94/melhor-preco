<?php

namespace Integrations\Bling\Products\Repositories\Contracts;

use Integrations\Bling\Products\Responses\Contracts\Response;
use Integrations\Bling\Products\Responses\ProductIterator;

interface Repository
{
    public function all(array $stores = []): ProductIterator;

    public function get(string $sku, array $stores = []): Response;

    // To Do: add this mehod
    //public function update(string $sku, array $data): bool;
}
