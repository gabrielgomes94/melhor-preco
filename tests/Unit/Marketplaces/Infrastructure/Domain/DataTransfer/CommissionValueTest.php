<?php

namespace Tests\Unit\Marketplaces\Infrastructure\Domain\DataTransfer;

use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValue;
use Src\Math\Percentage;
use Tests\TestCase;

class CommissionValueTest extends TestCase
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
