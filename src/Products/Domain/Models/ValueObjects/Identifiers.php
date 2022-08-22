<?php

namespace Src\Products\Domain\Models\ValueObjects;

class Identifiers
{
    private string $sku;
    private string $erpId;
    private string $ean;

    public function __construct(string $sku, string $erpId, string $ean)
    {
        $this->sku = $sku;
        $this->erpId = $erpId;
        $this->ean = $ean;
    }

    public function getEan(): string
    {
        return $this->ean;
    }

    public function getErpId(): string
    {
        return $this->erpId;
    }

    public function getSku(): string
    {
        return $this->sku;
    }
}
