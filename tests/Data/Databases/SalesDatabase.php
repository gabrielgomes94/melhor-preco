<?php

namespace Tests\Data\Databases;

use Src\Users\Domain\Models\User;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Sales\SaleOrderData;

class SalesDatabase
{
    public static function setup(User $user)
    {
        $shopee = MarketplaceData::shopee($user);
        $olist = MarketplaceData::olist($user);

        SaleOrderData::sale_100(user: $user, marketplace: $shopee);
        SaleOrderData::sale_101(user: $user, marketplace: $shopee);
        SaleOrderData::sale_102(user: $user, marketplace: $shopee);
        SaleOrderData::sale_103(user: $user, marketplace: $olist);
        SaleOrderData::sale_104(user: $user, marketplace: $olist);
    }
}
