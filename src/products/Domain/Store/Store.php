<?php

namespace Src\Products\Domain\Store;

use InvalidArgumentException;
use Src\Products\Domain\Store\Contracts\Store as StoreInterface;

class Store implements StoreInterface
{
    private array $validStores = [
        'b2w',
        'magalu',
        'mercado_livre',
        'olist',
        'shopee',
        'via_varejo',
    ];

    private string $slug;
    private string $name;
    private string $erpCode;
    private float $defaultCommission;

    public function __construct(string $slug, string $name, string $erpCode, string $defaultCommission)
    {
        if (!in_array($slug, $this->validStores)) {
            throw new InvalidArgumentException();
        }

        $this->slug = $slug;
        $this->name = $name;
        $this->erpCode = $erpCode;
        $this->defaultCommission = $defaultCommission;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getErpCode(): string
    {
        return $this->erpCode;
    }

    public function getDefaultCommission(): float
    {
        return $this->defaultCommission;
    }
}