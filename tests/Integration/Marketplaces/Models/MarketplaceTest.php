<?php

namespace Tests\Integration\Marketplaces\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValue;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Math\Percentage;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class MarketplaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_make_marketplace_model(): void
    {
        $expectedCommission = Commission::fromArray(
            'uniqueCommission',
            new CommissionValuesCollection([
                new CommissionValue(Percentage::fromPercentage(12.8))
            ])
        );
        $user = UserData::make();

        // Act
        $result = MarketplaceData::persisted($user);

        // Assert
        $this->assertSame('123456', $result->getErpId());
        $this->assertEquals($expectedCommission, $result->getCommission());
        $this->assertSame('Magalu', $result->getName());
        $this->assertSame('magalu', $result->getSlug());
        $this->assertInstanceOf(User::class, $result->getUser());
        $this->assertTrue($result->isActive());
        $this->assertFalse($result->slugsExists());
        $this->assertSame('1', $result->getUserId());
    }

    public function test_should_get_prices_relationship(): void
    {

    }

    public function test_should_get_products_relationship(): void
    {

    }

    public function test_should_get_user_relationship(): void
    {

    }

    public function test_should_get_data(): void
    {

    }

    public function test_should_set_commission_by_category(): void
    {

    }

    public function test_should_set_commission_by_unique_value(): void
    {

    }

    public function test_should_query_by_erp_id(): void
    {

    }

    public function test_should_query_by_user_id(): void
    {

    }

    public function test_should_query_by_slug(): void
    {

    }
}
