<?php

namespace Integrations\Bling\Products\Repositories\Contracts;

use Integrations\Bling\Products\Responses\Data\Product;

interface Repository
{
    public function all(array $stores = []): array;

    public function get(string $sku, array $stores = []): ?Product;

    public function update(string $sku, array $data): bool;
}
