<?php

namespace Src\Calculator\Domain\Models\Price\Commission\Factories;

use Src\Calculator\Domain\Models\Price\Commission\MercadoLivre;
use Money\Money;
use Src\Calculator\Domain\Models\Price\Commission\Commission;

class Factory
{
    public static function make(string $store, Money $price, float $commissionRate): Commission
    {
        if ($store === 'mercado-livre') {
            return new MercadoLivre($price, $commissionRate);
        }

        return new Commission($price, $commissionRate);
    }
}
