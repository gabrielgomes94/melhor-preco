<?php

namespace Src\Marketplaces\Domain\Models\Commission;

use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Math\Percentage;
use Tests\Data\Domain\Marketplaces\Models\CommissionValuesCollectionData;
use Tests\TestCase;

class CategoryCommissionTest extends TestCase
{
    public function test_should_get_commission_percentage(): void
    {
        // Arrange
        $commission = $this->getCommission();

        // Act
        $result = $commission->get('1');

        // Assert
        $this->assertInstanceOf(Percentage::class, $result);
        $this->assertSame(10.0, $result->get());
    }

    public function test_should_not_get_commission_percentage(): void
    {
        // Arrange
        $commission = $this->getCommission();

        // Act
        $result = $commission->get('100');

        // Assert
        $this->assertNull($result);
    }

    public function test_should_get_commission_values()
    {
        // Arrange
        $commission = $this->getCommission();

        // Act
        $result = $commission->getValues();

        // Arrange
        $this->assertCount(3, $result->get());
    }

    private function getCommission(): Commission
    {
        $commissionValuesCollection = CommissionValuesCollectionData::make();

        return Commission::fromArray('categoryCommission', $commissionValuesCollection);
    }
}
