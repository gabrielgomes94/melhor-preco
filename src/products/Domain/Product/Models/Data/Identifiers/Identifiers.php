<?php

namespace Src\Products\Domain\Product\Models\Data\Identifiers;

use Src\Products\Domain\Product\Contracts\Models\Data\Identifiers\Identifiers as IdentifiersInterface;

class Identifiers implements IdentifiersInterface
{
    private string $sku;
    private string $erpId;
    private array $storeSkuIds;

    public function __construct(string $sku, string $erpId, array $storeSkuIds = [])
    {
        $this->sku = $sku;
        $this->erpId = $erpId;
        $this->storeSkuIds = $storeSkuIds;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getErpId(): string
    {
        return $this->erpId;
    }

    public function getStoreSkuId(string $store): array
    {
        return $this->storeSkuIds;
    }
}
