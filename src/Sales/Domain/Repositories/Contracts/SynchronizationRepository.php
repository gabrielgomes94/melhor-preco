<?php

namespace Src\Sales\Domain\Repositories\Contracts;

use Src\Sales\Domain\Models\Contracts\SaleOrder as SaleOrderInterface;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Infrastructure\Bling\Data\SaleOrder as SaleOrderData;

interface SynchronizationRepository
{
    public function insert(SaleOrderData $externalSaleOrder, string $userId): SaleOrder;

    public static function syncPayment(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void;

    public static function syncInvoice(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void;

    public static function syncShipment(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void;

    public static function syncItems(SaleOrder $internalSaleOrder, SaleOrderInterface $externalSaleOrder): void;
}
