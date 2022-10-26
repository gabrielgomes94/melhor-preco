<?php

namespace Src\Sales\Application\Repositories;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Application\Models\Invoice;
use Src\Sales\Application\Models\SaleOrder;
use Src\Sales\Application\Models\Shipment;
use Tests\Data\Databases\SalesDatabase;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Sales\SaleInvoiceData;
use Tests\Data\Models\Sales\SaleOrderData;
use Tests\Data\Models\Sales\ShipmentData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class SaleOrderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_get_last_sale_date_time(): void
    {
        // Arrange
        $user = UserData::persisted();
        SalesDatabase::setup($user);

        /** @var SaleOrderRepository $repository */
        $repository = app(SaleOrderRepository::class);

        // Act
        $result = $repository->getLastSaleDateTime($user->getId());

        // Assert
        $this->assertInstanceOf(Carbon::class, $result);
    }

    public function test_should_not_get_last_sale_date_time_when_user_doest_not_have_sales(): void
    {
        // Arrange
        $user = UserData::persisted();

        /** @var SaleOrderRepository $repository */
        $repository = app(SaleOrderRepository::class);

        // Act
        $result = $repository->getLastSaleDateTime($user->getId());

        // Assert
        $this->assertNull($result);
    }

    public function test_should_count_sales(): void
    {
        // Arrange
        $user = UserData::persisted();
        SalesDatabase::setup($user);

        /** @var SaleOrderRepository $repository */
        $repository = app(SaleOrderRepository::class);

        // Act
        $result = $repository->countSales($user->getId());

        // Assert
        $this->assertSame(5, $result);
    }

    public function test_should_list_paginate(): void
    {
        // Arrange
        $user = UserData::persisted();
        SalesDatabase::setup($user);

        /** @var SaleOrderRepository $repository */
        $repository = app(SaleOrderRepository::class);

        $filter = new SalesFilter(
            $user->getId(),
            null,
            null,
            null,
            2,
            3
        );

        // Act
        $result = $repository->listPaginate($filter);

        // Assert
        $this->assertInstanceOf(Paginator::class, $result);
        $this->assertCount(2, $result->items());
    }

    public function test_should_list(): void
    {
        // Arrange
        $user = UserData::persisted();
        SalesDatabase::setup($user);

        /** @var SaleOrderRepository $repository */
        $repository = app(SaleOrderRepository::class);

        // Act
        $result = $repository->list($user->getId());

        // Assert
        $this->assertContainsOnlyInstancesOf(SaleOrder::class, $result);
        $this->assertCount(5, $result);
    }

    public function test_should_insert_sale_invoice(): void
    {
        // Arrange
        $user = UserData::persisted();
        SalesDatabase::setup($user);

        /** @var SaleOrderRepository $repository */
        $repository = app(SaleOrderRepository::class);

        $externalSaleOrder = new SaleOrder(['sale_order_id' => '100']);
        $externalSaleOrder->uuid = '316f4bd4-f05c-40ca-bcd2-6d2ac21ef33d';
        $externalSaleOrder->setRelation('invoice', SaleInvoiceData::build($externalSaleOrder));
        $internalSaleOrder = SaleOrderData::sale_100($user);

        // Act
        $repository->insertSaleInvoice($internalSaleOrder, $externalSaleOrder);

        // Assert
        $this->assertInstanceOf(Invoice::class, $internalSaleOrder->getInvoice());
    }

    public function test_should_insert_shipment(): void
    {
        // Arrange
        $user = UserData::persisted();
//        SalesDatabase::setup($user);

        /** @var SaleOrderRepository $repository */
        $repository = app(SaleOrderRepository::class);

        $externalSaleOrder = new SaleOrder(['sale_order_id' => '100']);
        $externalSaleOrder->uuid = '316f4bd4-f05c-40ca-bcd2-6d2ac21ef33d';
        $externalSaleOrder->setRelation('shipment', ShipmentData::build($externalSaleOrder));
        $internalSaleOrder = SaleOrderData::sale_100($user);

        // Act
        $repository->insertShipment($internalSaleOrder, $externalSaleOrder);

        // Assert
        $this->assertInstanceOf(Shipment::class, $internalSaleOrder->getShipment());
    }

    public function test_should_insert_sale_order(): void
    {
        // Arrange
        $user = UserData::persisted();
        $marketplace = MarketplaceData::shopee($user);

        /** @var SaleOrderRepository $repository */
        $repository = app(SaleOrderRepository::class);

        $externalSaleOrder = new SaleOrder([
            'sale_order_id' => '100',
            'store_id' => $marketplace->getErpId(),
            'selled_at' => Carbon::create(2022, 01, 12, 9, 23),
            'status' => 'Aprovado',
            'total_products' => 1,
            'total_value' => 100.0,
        ]);
        $externalSaleOrder->uuid = '316f4bd4-f05c-40ca-bcd2-6d2ac21ef33d';

        // Act
        $result = $repository->insertSaleOrder($externalSaleOrder, $user->getId());

        // Assert
        $this->assertInstanceOf(SaleOrder::class, $result);
        $this->assertDatabaseCount('sales_orders', 1);
    }

    public function test_should_update_profit(): void
    {
        // Arrange
        $user = UserData::persisted();
        SalesDatabase::setup($user);

        /** @var SaleOrderRepository $repository */
        $repository = app(SaleOrderRepository::class);

        $sale = SaleOrderData::sale_100($user);

        // Act
        $result = $repository->updateProfit($sale, 6.5);

        // Assert
        $this->assertTrue($result);

        $sale = $sale->refresh();
        $this->assertSame(6.5, $sale->getProfit());

    }

    public function test_should_update_status(): void
    {
        // Arrange
        $user = UserData::persisted();
        SalesDatabase::setup($user);

        /** @var SaleOrderRepository $repository */
        $repository = app(SaleOrderRepository::class);

        $sale = SaleOrderData::sale_100($user);

        // Act
        $result = $repository->updateStatus($sale,  'Cancelado');

        // Assert
        $this->assertTrue($result);

        $sale = $sale->refresh();
        $this->assertSame('Cancelado', $sale->getStatus());
    }

    public function test_should_get_sale_order(): void
    {
        // Arrange
        $user = UserData::persisted();
        SalesDatabase::setup($user);

        /** @var SaleOrderRepository $repository */
        $repository = app(SaleOrderRepository::class);

        // Act
        $result = $repository->get('100', $user->getId());

        // Assert
        $this->assertInstanceOf(SaleOrder::class, $result);
    }
}
