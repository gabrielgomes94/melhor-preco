<?php

namespace Src\Prices\Calculator\Domain\Price\Freight\Factories;

use Src\Prices\Calculator\Domain\Price\Freight\MercadoLivre;
use Src\Prices\Calculator\Domain\Price\Freight\NoFreight;
use Src\Products\Domain\Data\Dimensions;
use Barrigudinha\Store\Store;
use Money\Money;
use Src\Prices\Calculator\Domain\Price\Freight\B2W;
use Src\Prices\Calculator\Domain\Price\Freight\BaseFreight;
use Src\Prices\Calculator\Domain\Price\Freight\Olist;

class Factory
{
    private static array $customFreights = [
        Store::B2W => B2W::class,
        Store::MERCADO_LIVRE => MercadoLivre::class,
        Store::OLIST => Olist::class,
    ];

    public static function make(string $store, Dimensions $dimensions, Money $value, ?bool $ignoreFreight = null): BaseFreight
    {
        if ($ignoreFreight) {
            return new NoFreight($dimensions, $value);
        }

        /**
         * @var \Src\Prices\Calculator\Domain\Price\Freight\BaseFreight $freightClass
         */
        foreach (self::$customFreights as $storeSlug => $freightClass) {
            if ($store === $storeSlug) {
                return new $freightClass($dimensions, $value);
            }
        }

        return new NoFreight($dimensions, $value);
    }
}
