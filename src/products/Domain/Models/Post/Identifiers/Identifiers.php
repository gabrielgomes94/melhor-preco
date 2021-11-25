<?php

namespace Src\Products\Domain\Models\Post\Identifiers;

class Identifiers
{
    private string $id;
    private string $storeSkuId;

    public function __construct(string $id, string $storeSkuId)
    {
        $this->id = $id;
        $this->storeSkuId = $storeSkuId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStoreSkuId(): string
    {
        return $this->storeSkuId;
    }
}
