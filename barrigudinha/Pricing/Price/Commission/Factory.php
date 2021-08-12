<?php

namespace Barrigudinha\Pricing\Price\Commission;

use Barrigudinha\Store\Store;
use Money\Money;

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
