<?php

namespace Src\Products\Domain\Product\Contracts\Models\Data\Identifiers;

interface Identifiers
{
    public function __construct(string $sku, string $erpId, array $storeSkuIds = []);

    public function getSku(): string;

    public function getErpId(): string;

    public function getStoreSkuId(string $store): array;
}
