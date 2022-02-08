<?php

namespace Src\Products\Domain\Repositories\Contracts\Erp;

use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Products\Infrastructure\Bling\Responses\Prices\PricesCollectionResponse;

interface ProductRepository
{
    public function all();

    public function allInMarketplace(Marketplace $marketplace, string $status, int $page): PricesCollectionResponse;

    public function get(string $sku);

    public function uploadImages(string $sku, string $path, array $images);
}
