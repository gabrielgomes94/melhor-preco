<?php

namespace Barrigudinha\Pricing\Price\Freight;

use Barrigudinha\Product\Data\Dimensions;
use Barrigudinha\Store\Store;
use Money\Money;

class Factory
{
    private static array $customFreights = [
        Store::B2W => B2W::class,
        Store::MERCADO_LIVRE => MercadoLivre::class,
        Store::OLIST => Olist::class,
    ];

    public static function make(string $store, Dimensions $dimensions, Money $value): BaseFreight
    {
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
