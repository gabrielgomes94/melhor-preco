<?php

namespace Tests\Data\Domain\Sales;

use Src\Sales\Domain\DataTransfer\Reports\ListMetadata;
use Src\Sales\Domain\DataTransfer\Reports\ListReport;
use Src\Sales\Application\Reports\Data\Marketplace\MarketplaceSalesTest;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\Models\Collections\SaleItemsCollection;
use Src\Sales\Domain\Models\Collections\SaleOrdersCollection;
use Src\Users\Domain\Models\User;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Sales\SaleItemData;
use Tests\Data\Models\Sales\SaleOrderData;

class ListReportData
{
    public static function make(User $user): ListReport
    {
        $marketplace = MarketplaceData::shopee($user);
        $product = ProductData::babyPacifier($user);

        $sales = new SaleOrdersCollection([
            SaleOrderData::sale_100(user: $user, marketplace: $marketplace),
            SaleOrderData::sale_101(user: $user, marketplace: $marketplace),
            SaleOrderData::sale_102(user: $user, marketplace: $marketplace),
            SaleOrderData::sale_103(user: $user, marketplace: $marketplace),
            SaleOrderData::sale_104(user: $user, marketplace: $marketplace),
        ]);

        $marketplaceSales = new MarketplaceSalesTest(
            $marketplace,
            new SaleItemsCollection([
                SaleItemData::make($product),
                SaleItemData::make($product),
                SaleItemData::make($product),
                SaleItemData::make($product),
                SaleItemData::make($product)
            ])
        );

        $metadata = new ListMetadata(
            5,
            5,
            [$marketplaceSales],
            2000.0,
            350.0
        );

        $filter = new SalesFilter($user->getId());

        return new ListReport(
            $metadata,
            $filter,
            $sales,
            5
        );
    }
}
