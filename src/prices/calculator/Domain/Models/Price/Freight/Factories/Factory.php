<?php

namespace Src\Prices\Calculator\Domain\Models\Price\Freight\Factories;

use Src\Prices\Calculator\Domain\Models\Price\Freight\MercadoLivre;
use Src\Prices\Calculator\Domain\Models\Price\Freight\NoFreight;
use Money\Money;
use Src\Prices\Calculator\Domain\Models\Price\Freight\B2W;
use Src\Prices\Calculator\Domain\Models\Price\Freight\BaseFreight;
use Src\Prices\Calculator\Domain\Models\Price\Freight\Olist;
use Src\Products\Domain\Product\Contracts\Models\Data\Dimensions\Dimensions;
use Src\Products\Domain\Store\Store;

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
         * @var \Src\Prices\Calculator\Domain\Models\Price\Freight\BaseFreight $freightClass
         */
        foreach (self::$customFreights as $storeSlug => $freightClass) {
            if ($store === $storeSlug) {
                return new $freightClass($dimensions, $value);
            }
        }

        return new NoFreight($dimensions, $value);
    }
}
