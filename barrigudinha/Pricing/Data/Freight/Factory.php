<?php

namespace Barrigudinha\Pricing\Data\Freight;

use Barrigudinha\Product\Entities\Product;
use Barrigudinha\Store\Store;
use Money\Money;

class Factory
{
    private static array $customFreights = [
        Store::B2W => B2W::class,
        Store::MERCADO_LIVRE => MercadoLivre::class,
        Store::OLIST => Olist::class,
    ];

    public static function make(string $store, Product $product, Money $value): BaseFreight
    {
        /**
         * @var BaseFreight $class
         */
        foreach (self::$customFreights as $storeSlug => $freightClass) {
            if ($store === $storeSlug) {
                return new $freightClass($product, $value);
            }
        }

        return new NoFreight($product, $value);
    }
}
