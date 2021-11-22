<?php

namespace Src\Sales\Domain\Repositories\Contracts;

use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;
use Src\Sales\Infrastructure\Bling\Data\SaleOrder as SaleOrderData;
use Src\Sales\Domain\Models\SaleOrder;

interface Repository
{
    public const PER_PAGE = 40;

    public static function insert(SaleOrderData $externalSaleOrder): SaleOrder;

    public static function listPaginate(
        int $page,
        int $perPage = self::PER_PAGE,
        ?\DateTime $beginDate = null,
        ?\DateTime $endDate = null
    );

    public static function getTotalValueSum(
        ?\DateTime $beginDate = null,
        ?\DateTime $endDate = null
    );

    public static function getTotalProfitSum(
        ?\DateTime $beginDate = null,
        ?\DateTime $endDate = null
    );

    public static function syncPayment(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void;

    public static function syncInvoice(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void;

    public static function syncShipment(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void;

    public static function syncItems(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void;

    public static function updateProfit(SaleOrder $saleOrder, float $profit): void;
}
