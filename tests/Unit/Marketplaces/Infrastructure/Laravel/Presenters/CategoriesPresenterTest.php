<?php

namespace Tests\Unit\Marketplaces\Infrastructure\Laravel\Presenters;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery as m;
use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValue;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Marketplaces\Infrastructure\Laravel\Presenters\CategoriesPresenter;
use Src\Math\Percentage;
use Src\Products\Domain\Repositories\CategoryRepository;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class CategoriesPresenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_present_categories_with_commission(): void
    {
        // Arrange
        $repository = m::mock(CategoryRepository::class);
        $presenter = new CategoriesPresenter($repository);

        $user = UserData::make();

        $marketplace = MarketplaceData::persisted(
            $user,
            [
                'commission' => Commission::fromArray(
                    Commission::CATEGORY_COMMISSION,
                    new CommissionValuesCollection([
                        new CommissionValue(
                            Percentage::fromPercentage(12.8), '1'
                        ),
                        new CommissionValue(
                            Percentage::fromPercentage(8.8), '10'
                        ),
                    ])
                ),
            ],
            'categoryCommission'
        );

        $expected = [
            [
                'name' => 'Carrinhos',
                'categoryId' => '1',
                'parentId' => '',
                'commission' => 12.8,
            ],
            [
                'name' => 'Carrinhos / Carrinhos de supermercado',
                'categoryId' => '10',
                'parentId' => '1',
                'commission' => 8.8,
            ],
        ];

        // Expect
        $repository->expects()
            ->list('1')
            ->andReturn([
                CategoryData::persisted($user, ['category_id' => '1'], 'withoutParent'),
                CategoryData::persisted($user, ['category_id' => '10', 'parent_id' => '1']),
            ]);

        // Act
        $result = $presenter->presentWithCommission($marketplace, '1');

        // Assert
        $this->assertSame($expected, $result);
    }
}
