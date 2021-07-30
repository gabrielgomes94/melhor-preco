<?php

namespace Integrations\Bling\Products\Repositories\Contracts;

use Integrations\Bling\Products\Data\Product;
use Integrations\Bling\Products\Data\ProductIterator;

interface Repository
{
    public function all(array $stores = []): ProductIterator;

    public function get(string $sku, array $stores = []): ?Product;

    public function update(string $sku, array $data): bool;
}
