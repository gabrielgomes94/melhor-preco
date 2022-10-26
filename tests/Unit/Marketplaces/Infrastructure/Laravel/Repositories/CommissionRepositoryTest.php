<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValue;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Math\Transformers\MoneyTransformer;
use Src\Math\Percentage;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class CommissionRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_get_commission_when_does_not_have_maximum_value_cap(): void
    {
        // Arrange
        $user = UserData::persisted();
        $product = ProductData::babyCarriage($user);
        $marketplace = MarketplaceData::olist($user);

        $repository = new CommissionRepository();

        // Act
        $result = $repository->get($marketplace, $product, 100.0);

        // Assert
        $this->assertEquals(20.0, $result);
    }

    public function test_should_get_commission_when_its_greater_than_maximum_value_cap(): void
    {
        // Arrange
        $user = UserData::persisted();
        $product = ProductData::babyCarriage($user);
        $marketplace = MarketplaceData::shopee($user);

        $repository = new CommissionRepository();

        // Act
        $result = $repository->get($marketplace, $product, 1200.0);

        // Assert
        $this->assertEquals(100.0, $result);
    }

    public function test_should_get_commission_when_its_not_greater_than_maximum_value_cap(): void
    {
        // Arrange
        $user = UserData::persisted();
        $product = ProductData::babyCarriage($user);
        $marketplace = MarketplaceData::shopee($user);

        $repository = new CommissionRepository();

        // Act
        $result = $repository->get($marketplace, $product, 70.0);

        // Assert
        $this->assertEquals(8.40, $result);
    }

    public function test_should_get_commission_rate_when_is_unique_commission(): void
    {
        // Arrange
        $user = UserData::persisted();
        $product = ProductData::babyCarriage($user);
        $marketplace = MarketplaceData::shopee($user, []);

        $repository = new CommissionRepository();

        // Act
        $result = $repository->getCommissionRate($marketplace);

        // Assert
        $this->assertSame(0.12, $result->getFraction());
    }

    public function test_should_get_commission_rate_when_is_commission_by_category(): void
    {
        // Arrange
        $user = UserData::persisted();
        $category = CategoryData::persisted($user, ['category_id' => '1'], 'withoutParent');
        ProductData::babyCarriage($user, [], $category);
        $marketplace = MarketplaceData::magalu($user);
        $repository = new CommissionRepository();

        // Act
        $result = $repository->getCommissionRate($marketplace, '1');

        // Assert
        $this->assertSame(0.128, $result->getFraction());
    }

    public function test_should_get_zero_commission_rate(): void
    {
        // Arrange
        $user = UserData::persisted();
        ProductData::babyCarriage($user);
        $marketplace = MarketplaceData::olist($user);
        $marketplace->commission = Commission::build(Commission::UNIQUE_COMMISSION);
        $marketplace->save();

        $repository = new CommissionRepository();

        // Act
        $result = $repository->getCommissionRate($marketplace, '100');

        // Assert
        $this->assertSame(0.0, $result->getFraction());
    }

    public function test_should_update_category_commission(): void
    {
        // Arrange
        $user = UserData::persisted();
        $marketplace = MarketplaceData::magalu($user);
        $data = new CommissionValuesCollection([
            new CommissionValue(Percentage::fromPercentage(10.0), '1')
        ]);

        $repository = new CommissionRepository();

        // Act
        $result = $repository->update($marketplace, $data);

        // Assert
        $this->assertTrue($result);

        $marketplace = $marketplace->refresh();
        $this->assertSame(10.0, $marketplace->getCommission()->get(1)->get());
    }

    public function test_should_update_unique_commission(): void
    {
        // Arrange
        $user = UserData::persisted();
        $marketplace = MarketplaceData::magalu($user);

        $repository = new CommissionRepository();

        // Act
        $result = $repository->update($marketplace, new CommissionValuesCollection([
            new CommissionValue(
                Percentage::fromPercentage(5.0)
            )
        ]));

        // Assert
        $this->assertTrue($result);

        $marketplace = $marketplace->refresh();
        $this->assertSame(5.0, $marketplace->getCommission()->get()->get());
    }
}
