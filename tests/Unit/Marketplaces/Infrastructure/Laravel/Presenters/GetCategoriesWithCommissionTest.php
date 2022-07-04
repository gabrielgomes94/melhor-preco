<?php

namespace Tests\Unit\Marketplaces\Infrastructure\Laravel\Presenters;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Domain\Services\GetCategoriesWithCommissions;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

// @todo: refatorar esse teste para ele ficar mais unitário
class GetCategoriesWithCommissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_get_categories_with_commission(): void
    {
        // Arrange
        $user = UserData::make();
        CategoryData::persisted('withoutParent', $user, ['category_id' => '1']);
        CategoryData::persisted('withParent', $user, ['category_id' => '10']);
        $marketplace = MarketplaceData::persisted(
            $user,
            [
                'extra' => [
                    'commissionValues' => [
                        [
                            'categoryId' => 1,
                            'commission' => 12.8,
                        ],
                        [
                            'categoryId' => 10,
                            'commission' => 8.8,
                        ],
                    ],
                    'commissionType' => 'categoryCommission',
                ]
            ],
            'categoryCommission'
        );
        $getCategoriesWithCommissions = $this->app->get(GetCategoriesWithCommissions::class);
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

        // Act
        $result = $getCategoriesWithCommissions->get($marketplace, $user->getId());

        // Assert
        $this->assertSame($expected, $result);

    }
}
