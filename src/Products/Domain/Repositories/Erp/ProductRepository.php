<?php

namespace Src\Products\Domain\Repositories\Erp;

use Src\Integrations\Bling\Base\Responses\BaseResponse;
use Src\Marketplaces\Domain\Models\Marketplace;

interface ProductRepository
{
    public function all(string $erpToken);

    public function allInMarketplace(
        string $erpToken,
        Marketplace $marketplace,
        string $status,
        int $page
    ): BaseResponse;

    public function get(string $erpToken, string $sku);

    public function uploadImages(string $erpToken, string $sku, string $path, array $images): bool;
}
