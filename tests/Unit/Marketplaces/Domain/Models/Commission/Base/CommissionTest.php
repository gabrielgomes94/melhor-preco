<?php

namespace Src\Marketplaces\Domain\Models\Commission\Base;

use Src\Marketplaces\Domain\Exceptions\InvalidCommissionTypeException;
use Src\Marketplaces\Domain\Models\Commission\CategoryCommission;
use Src\Marketplaces\Domain\Models\Commission\UniqueCommission;
use Tests\Data\Domain\Marketplaces\Models\CommissionValuesCollectionData;
use Tests\TestCase;

class CommissionTest extends TestCase
{
    /**
     * @dataProvider getScenarios
     */
    public function test_should_instantiate_from_array(string $type, string $expected): void
    {
        // Arrange
        $commissionValuesCollection = CommissionValuesCollectionData::make($type);

        // Act
        $result = Commission::build($type, $commissionValuesCollection);

        // Assert
        $this->assertInstanceOf($expected, $result);
        $this->assertNull($result->getMaximumValueCap());
        $this->assertFalse($result->hasMaximumValueCap());
    }

    public function test_should_instantiate_with_maximum_value_cap()
    {
        // Arrange
        $commissionValuesCollection = CommissionValuesCollectionData::make('uniqueCommission');

        // Act
        $result = Commission::build('uniqueCommission', $commissionValuesCollection, 100);

        // Assert
        $this->assertSame(100.0, $result->getMaximumValueCap());
        $this->assertTrue($result->hasMaximumValueCap());
    }

    public function test_should_handle_error_when_instantiating(): void
    {
        // Expect
        $this->expectException(InvalidCommissionTypeException::class);

        // Act
        $result = Commission::build('invalid', new CommissionValuesCollection());
    }

    public function test_should_get_type(): void
    {
        // Arrange
        $commissionValuesCollection = CommissionValuesCollectionData::make();
        $commission = Commission::build('categoryCommission', $commissionValuesCollection);

        // Act
        $result = $commission->getType();

        // Assert
        $this->assertSame('categoryCommission', $result);
    }

    public function test_should_check_if_is_commission_by_category(): void
    {
        // Arrange
        $commissionValuesCollection = CommissionValuesCollectionData::make();
        $commission = Commission::build('categoryCommission', $commissionValuesCollection);

        // Act
        $result = $commission->hasCommissionByCategory();

        // Assert
        $this->assertTrue($result);
    }

    public function test_should_check_if_is_unique_commission(): void
    {
        // Arrange
        $commissionValuesCollection = CommissionValuesCollectionData::make();
        $commission = Commission::build('categoryCommission', $commissionValuesCollection);

        // Act
        $result = $commission->hasUniqueCommission();

        // Assert
        $this->assertFalse($result);
    }
    public function getScenarios(): array
    {
        return [
            'when given unique commission' => [
                'type' => 'uniqueCommission',
                'expected' => UniqueCommission::class,
            ],
            'when given category commission' => [
                'type' => 'categoryCommission',
                'expected' => CategoryCommission::class,
            ]
        ];
    }
}
