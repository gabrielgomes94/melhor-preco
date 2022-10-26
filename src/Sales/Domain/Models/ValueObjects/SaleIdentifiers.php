<?php

namespace Src\Sales\Domain\Models\ValueObjects;

class SaleIdentifiers
{
    public function __construct(
        private readonly string $saleOrderId,
        private readonly string $uuid,
        private readonly ?string $integration,
        private readonly ?string $storeId,
        private readonly ?string $storeSaleOrderId
    ) {
    }

    public function saleOrderId(): string
    {
        return $this->saleOrderId;
    }

    public function integration(): ?string
    {
        return $this->integration;
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
            'storeId' => $this->storeId,
            'storeSaleOrderId' => $this->storeSaleOrderId,
            'integration' => $this->integration,
        ];
    }
}
