<?php

namespace Src\Prices\Domain\Price\Freight\Factories;

use Src\Prices\Domain\Price\Freight\MercadoLivre;
use Src\Prices\Domain\Price\Freight\NoFreight;
use Barrigudinha\Product\Data\Dimensions;
use Barrigudinha\Store\Store;
use Money\Money;
use Src\Prices\Domain\Price\Freight\B2W;
use Src\Prices\Domain\Price\Freight\BaseFreight;
use Src\Prices\Domain\Price\Freight\Olist;

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
         * @var BaseFreight $freightClass
         */
        foreach (self::$customFreights as $storeSlug => $freightClass) {
            if ($store === $storeSlug) {
                return new $freightClass($dimensions, $value);
            }
        }

        return new NoFreight($dimensions, $value);
    }
}
