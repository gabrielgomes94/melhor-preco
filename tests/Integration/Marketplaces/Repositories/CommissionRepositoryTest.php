<?php

namespace Tests\Integration\Marketplaces\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValue;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Marketplaces\Domain\Repositories\CommissionRepository;
use Src\Math\Percentage;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class CommissionRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_get_unique_commission(): void
    {
        // Arrange
        $user = UserData::make();
        $product = ProductData::makePersisted($user);
        $marketplace = MarketplaceData::shopee($user, []);
        $repository = $this->app->get(CommissionRepository::class);

        // Act
        $result = $repository->get($marketplace, $product);

        // Assert
        $this->assertSame(0.128, $result->getFraction());
    }

    public function test_should_get_commission_by_category(): void
    {
        // Arrange
        $user = UserData::make();
        $category = CategoryData::persisted($user, ['category_id' => '1'], 'withoutParent');
        $product = ProductData::makePersisted($user, ['category_id' => $category->getCategoryId()]);
        $marketplace = MarketplaceData::magalu($user, [], 'categoryCommission');
        $repository = $this->app->get(CommissionRepository::class);

        // Act
        $result = $repository->get($marketplace, '1');

        // Assert
        $this->assertSame(0.128, $result->getFraction());
    }

    public function test_should_get_zero_commission(): void
    {
        // Arrange
        $user = UserData::make();
        $product = ProductData::makePersisted($user);
        $marketplace = MarketplaceData::olist($user);
        $marketplace->commission = Commission::build(Commission::UNIQUE_COMMISSION);
        $marketplace->save();

        $repository = $this->app->get(CommissionRepository::class);

        // Act
        $result = $repository->get($marketplace, $product);

        // Assert
        $this->assertSame(0.0, $result->getFraction());
    }

    public function test_should_update_category_commission(): void
    {
        // Arrange
        $user = UserData::make();
        $marketplace = MarketplaceData::magalu($user);
        $data = new CommissionValuesCollection([
            new CommissionValue(Percentage::fromPercentage(10.0), '1')
        ]);

        $repository = $this->app->get(CommissionRepository::class);

        // Act
        $result = $repository->updateCategoryCommissions($marketplace, $data);

        // Assert
        $this->assertTrue($result);

        $marketplace = $marketplace->refresh();
        $this->assertSame(10.0, $marketplace->getCommission()->get(1)->get());
    }

    public function test_should_update_unique_commission(): void
    {
        // Arrange
        $user = UserData::make();
        $marketplace = MarketplaceData::magalu($user);

        $repository = $this->app->get(CommissionRepository::class);

        // Act
        $result = $repository->updateUniqueCommission($marketplace, 5);

        // Assert
        $this->assertTrue($result);

        $marketplace = $marketplace->refresh();
        $this->assertSame(5.0, $marketplace->getCommission()->get()->get());
    }
}
