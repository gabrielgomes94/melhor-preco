<?php

namespace Src\Prices\Calculator\Domain\Price\Commission\Factories;

use Src\Prices\Calculator\Domain\Price\Commission\MercadoLivre;
use Barrigudinha\Store\Store;
use Money\Money;
use Src\Prices\Calculator\Domain\Price\Commission\Commission;

/**
 * To Do: Store para seu próprio contexto
 * Class Factory
 * @package Src\Prices\Calculator\Domain\Price\Commission\Factories
 */
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
