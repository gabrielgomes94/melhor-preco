<?php

namespace Src\Products\Domain\Repositories\Contracts\Erp;

use Src\Marketplaces\Domain\Models\Contracts\Marketplace;

interface ProductRepository
{
    public function all();

    public function allOnStore(Marketplace $marketplace);

    public function get(string $sku);

    public function uploadImages(string $sku, string $path, array $images);
}
