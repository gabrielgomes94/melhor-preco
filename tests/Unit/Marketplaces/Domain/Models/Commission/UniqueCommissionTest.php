<?php

namespace Src\Marketplaces\Domain\Models\Commission;

use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Math\Percentage;
use Tests\Data\Domain\Marketplaces\Models\CommissionValuesCollectionData;
use Tests\TestCase;

class UniqueCommissionTest extends TestCase
{
    public function test_should_get_commission_percentage()
    {
        // Arrange
        $commission = $this->getCommission();

        // Act
        $result = $commission->get();

        // Assert
        $this->assertInstanceOf(Percentage::class, $result);
        $this->assertSame(12.0, $result->get());
    }

    public function test_should_get_commission_values()
    {
        // Arrange
        $commission = $this->getCommission();

        // Act
        $result = $commission->getValues();

        // Arrange
        $this->assertCount(1, $result->get());
    }

    private function getCommission(): Commission
    {
        $commissionValuesCollection = CommissionValuesCollectionData::make('uniqueCommission');

        return Commission::fromArray('uniqueCommission', $commissionValuesCollection);
    }
}
