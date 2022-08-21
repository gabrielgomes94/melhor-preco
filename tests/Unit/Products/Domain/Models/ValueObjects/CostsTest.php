<?php

namespace Src\Products\Domain\Models\ValueObjects;

use PHPUnit\Framework\TestCase;

class CostsTest extends TestCase
{
    public function test_should_instantiate_costs(): void
    {
        // Act
        $instance = new Costs(100.0, 5.25, 12.0);

        // Assert
        $this->assertSame(100.0, $instance->purchasePrice());
        $this->assertSame(5.25, $instance->additionalCosts());
        $this->assertSame(12.0, $instance->taxICMS());
    }
}
