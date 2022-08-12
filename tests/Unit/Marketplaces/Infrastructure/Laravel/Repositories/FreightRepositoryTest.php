<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Domain\Models\Freight\Freight;
use Src\Marketplaces\Domain\Models\Freight\FreightTable;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class FreightRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_get_freight_when_value_is_lesser_than_minimum_freight_table_value(): void
    {
        // Arrange
        $repository = new FreightRepository();

        $user = UserData::make();
        $marketplace = MarketplaceData::olist($user);

        // Act
        $result = $repository->get($marketplace, 2.0, 20.0);

        // Assert
        $this->assertSame(5.0, $result);
    }

    public function test_should_get_freight_when_there_is_no_freight_table(): void
    {
        // Arrange
        $repository = new FreightRepository();

        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);

        // Act
        $result = $repository->get($marketplace, 2.0, 20.0);

        // Assert
        $this->assertSame(0.0, $result);
    }

    public function test_should_get_freight_from_table(): void
    {
        // Arrange
        $repository = new FreightRepository();

        $user = UserData::make();
        $marketplace = MarketplaceData::olist($user);

        // Act
        $result = $repository->get($marketplace, 1.0, 200.0);

        // Assert
        $this->assertSame(23.94, $result);
    }

    public function test_should_update_freight(): void
    {
        // Arrange
        $repository = new FreightRepository();

        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        $freight = new Freight(
            10.0,
            0.0,
            new FreightTable([])
        );

        // Act
        $result = $repository->update($marketplace, $freight);

        // Assert
        $this->assertTrue($result);

        $marketplace = $marketplace->refresh();
        $this->assertEquals($freight, $marketplace->getFreight());
    }
}
