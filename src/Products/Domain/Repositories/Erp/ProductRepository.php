<?php

namespace Src\Products\Domain\Repositories\Erp;

use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Products\Infrastructure\Bling\Responses\Prices\PricesCollectionResponse;

interface ProductRepository
{
    public function all(string $erpToken);

    public function allInMarketplace(
        string $erpToken,
        Marketplace $marketplace,
        string $status,
        int $page
    ): PricesCollectionResponse;

    public function get(string $erpToken, string $sku);

    public function uploadImages(string $erpToken, string $sku, string $path, array $images);
}
