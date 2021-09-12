<?php

namespace Barrigudinha\SaleOrder\ValueObjects;

class Identifiers
{
    private string $id;
    private string $purchaseOrderId;
    private ?string $integration;
    private ?string $storeId;
    private ?string $storeSaleOrderId;

    public function __construct(
        string $id,
        string $purchaseOrderId,
        ?string $integration,
        ?string $storeId,
        ?string $storeSaleOrderId
    ) {
        $this->id = $id;
        $this->purchaseOrderId = $purchaseOrderId;
        $this->integration = $integration;
        $this->storeId = $storeId;
        $this->storeSaleOrderId = $storeSaleOrderId;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function purchaseSaleOrderId(): string
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
            'id' => $this->id,
            'purchaseOrderId' => $this->purchaseOrderId,
            'storeId' => $this->storeId,
            'storeSaleOrderId' => $this->storeSaleOrderId,
            'integration' => $this->integration,
        ];
    }
}
