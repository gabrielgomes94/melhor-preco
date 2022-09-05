<?php

namespace Src\Prices\Infrastructure\Laravel\Providers;

use Src\Prices\Domain\Repositories\PricesRepository as PricesRepositoryInterface;
use Src\Prices\Domain\Repositories\ProductsRepository as ProductsRepositoryInterface;
use Src\Prices\Domain\Services\CalculatePriceFromProduct as CalculatePriceFromProductInterface;
use Src\Prices\Domain\Services\MassCalculatePrices as MassCalculatePricesInterface;
use Src\Prices\Domain\Services\SynchronizeFromMarketplace as SynchronizeFromMarketplaceInterface;
use Src\Prices\Infrastructure\Laravel\Repositories\PricesRepository;
use Src\Prices\Infrastructure\Laravel\Repositories\ProductsRepository;
use Src\Prices\Infrastructure\Laravel\Services\CalculatePriceFromProduct;
use Src\Prices\Infrastructure\Laravel\Services\MassCalculatePrices;
use Src\Prices\Infrastructure\Laravel\Services\SynchronizeFromMarketplace;
use Tests\TestCase;

class PricesServiceProviderTest extends TestCase
{
    public function test_should_bind_repositories(): void
    {
        // Act
        $pricesRepository = app(PricesRepositoryInterface::class);
        $productsRepository = app(ProductsRepositoryInterface::class);

        // Assert
        $this->assertInstanceOf(PricesRepository::class, $pricesRepository);
        $this->assertInstanceOf(ProductsRepository::class, $productsRepository);
    }

    public function test_should_bind_services(): void
    {
        // Act
        $calculatePriceFromProduct = app(CalculatePriceFromProductInterface::class);
        $massCalculatePrices = app(MassCalculatePricesInterface::class);
        $synchronizeFromMarketplace = app(SynchronizeFromMarketplaceInterface::class);

        // Assert
        $this->assertInstanceOf(CalculatePriceFromProduct::class, $calculatePriceFromProduct);
        $this->assertInstanceOf(MassCalculatePrices::class, $massCalculatePrices);
        $this->assertInstanceOf(SynchronizeFromMarketplace::class, $synchronizeFromMarketplace);
    }
}
