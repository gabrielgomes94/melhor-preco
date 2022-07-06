<?php

namespace Src\Marketplaces\Domain\Models\Commission\Base;

use Src\Math\Percentage;
use Tests\Data\Domain\Marketplaces\Models\CommissionValuesCollectionData;
use Tests\TestCase;

class CommissionValuesCollectionTest extends TestCase
{
    public function test_should_instantiate_commission_values_collection(): void
    {
        // Arrange
        $firstCommissionValue = new CommissionValue(
            Percentage::fromPercentage(10.0),
            '1'
        );
        $data = CommissionValuesCollectionData::categoryCommission();

        // Act

        $result = new CommissionValuesCollection($data);

        // Assert
        $this->assertContainsOnlyInstancesOf(CommissionValue::class, $result->get());
        $this->assertEquals($firstCommissionValue, $result->first());
    }
}
