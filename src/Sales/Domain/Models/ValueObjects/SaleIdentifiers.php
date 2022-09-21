<?php

namespace Src\Sales\Domain\Models\ValueObjects;

class SaleIdentifiers
{
    private string $saleOrderId;
    private string $uuid;
    private ?string $purchaseOrderId;
    private ?string $integration;
    private ?string $storeId;
    private ?string $storeSaleOrderId;

    public function __construct(
        string $saleOrderId,
        string $uuid,
        ?string $purchaseOrderId,
        ?string $integration,
        ?string $storeId,
        ?string $storeSaleOrderId
    ) {
        $this->saleOrderId = $saleOrderId;
        $this->uuid = $uuid;
        $this->purchaseOrderId = $purchaseOrderId;
        $this->integration = $integration;
        $this->storeId = $storeId;
        $this->storeSaleOrderId = $storeSaleOrderId;
    }

    public function saleOrderId(): string
    {
        return $this->saleOrderId;
    }

    public function integration(): ?string
    {
        return $this->integration;
    }

    public function purchaseSaleOrderId(): ?string
    {
        return $this->purchaseOrderId;
    }

    public function storeSaleOrderId(): string
    {
        return $this->storeSaleOrderId ?? '';
    }

    public function storeId(): ?string
    {
        return $this->storeId;
    }

    public function toArray(): array
    {
        return [
            'saleOrderId' => $this->saleOrderId,
            'uuid' => $this->uuid,
            'purchaseOrderId' => $this->purchaseOrderId,
            'storeId' => $this->storeId,
            'storeSaleOrderId' => $this->storeSaleOrderId,
            'integration' => $this->integration,
        ];
    }
}
