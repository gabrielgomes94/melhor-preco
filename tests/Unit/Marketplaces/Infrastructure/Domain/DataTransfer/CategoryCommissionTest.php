<?php

namespace Tests\Unit\Marketplaces\Infrastructure\Domain\DataTransfer;

use Src\Marketplaces\Domain\DataTransfer\CommissionValue;
use Src\Math\Percentage;
use Tests\TestCase;

class CategoryCommissionTest extends TestCase
{
    public function test_should_instantiate_category_commission(): void
    {
        // Act
        $result = new CommissionValue(
            Percentage::fromPercentage(10.0),
            '1'
        );

        // Assert
        $this->assertInstanceOf(Percentage::class, $result->commission);
        $this->assertSame(10.0, $result->commission->get());
        $this->assertSame('1', $result->categoryId);
    }
}
