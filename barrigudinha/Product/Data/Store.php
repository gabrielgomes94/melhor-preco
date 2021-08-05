<?php

namespace Barrigudinha\Product\Data;

use function config;

class Store
{
    // To Do: ajustar o padrao da declaração dessa variavel
    private string $store_sku_id;
    private string $code;
    private float $commission;

    public function __construct(
        string $store_sku_id,
        string $code
    ) {
        if (!in_array($code, array_keys(config('stores_code')))) {
            throw new \Exception('Invalid object store');
        }

        $this->store_sku_id = $store_sku_id;
        $this->code = $code;
        $this->commission = config('stores.' . $code . '.commission');
    }

    public static function createFromArray(array $data): self
    {
        $store = new self(
            store_sku_id: $data['storeSkuId'],
            code: $data['code']
        );

        return $store;
    }

    public function storeSkuId(): string
    {
        return $this->store_sku_id;
    }

    public function commission(): float
    {
        return $this->commission;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function slug(): string
    {
        return $this->code;
    }

    public function name(): string
    {
        return config('stores.' . $this->slug() . '.name');
    }
}
