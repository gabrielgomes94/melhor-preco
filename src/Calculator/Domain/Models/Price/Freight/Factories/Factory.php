<?php

namespace Src\Calculator\Domain\Models\Price\Freight\Factories;

use Src\Calculator\Domain\Models\Price\Freight\MercadoLivre;
use Src\Calculator\Domain\Models\Price\Freight\NoFreight;
use Money\Money;
use Src\Calculator\Domain\Models\Price\Freight\B2W;
use Src\Calculator\Domain\Models\Price\Freight\BaseFreight;
use Src\Calculator\Domain\Models\Price\Freight\Olist;
use Src\Products\Domain\Models\Product\Data\Dimensions;

class Factory
{
    private static array $customFreights = [
        'b2w' => B2W::class,
        'mercado-livre' => MercadoLivre::class,
        'olist' => Olist::class,
    ];

    public static function make(string $store, Dimensions $dimensions, Money $value, ?bool $freeFreight = null): BaseFreight
    {
        if (!$freeFreight) {
            return new NoFreight($dimensions, $value);
        }

        /**
         * @var \Src\Calculator\Domain\Models\Price\Freight\BaseFreight $freightClass
         */
        foreach (self::$customFreights as $storeSlug => $freightClass) {
            if ($store === $storeSlug) {
                return new $freightClass($dimensions, $value);
            }
        }

        return new NoFreight($dimensions, $value);
    }
}
