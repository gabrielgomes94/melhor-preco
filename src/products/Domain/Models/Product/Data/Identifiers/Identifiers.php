<?php

namespace Src\Products\Domain\Models\Product\Data\Identifiers;

class Identifiers
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
