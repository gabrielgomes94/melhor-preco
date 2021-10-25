<?php

namespace Src\Prices\Calculator\Domain\Price\Commission\Factories;

use Src\Prices\Calculator\Domain\Price\Commission\MercadoLivre;
use Money\Money;
use Src\Prices\Calculator\Domain\Price\Commission\Commission;
use Src\Products\Domain\Store\Store;

class Factory
{
    public static function make(string $store, Money $price, float $commissionRate): Commission
    {
        if ($store === Store::MERCADO_LIVRE) {
            return new MercadoLivre($price, $commissionRate);
        }

        return new Commission($price, $commissionRate);
    }
}
