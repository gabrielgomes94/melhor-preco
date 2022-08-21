<?php

namespace Src\Products\Domain\Models\ValueObjects;

use PHPUnit\Framework\TestCase;

class IdentifiersTest extends TestCase
{
    public function test_should_instantiate_identifiers(): void
    {
        // Act
        $instance = new Identifiers('1234', '12349876', '123456789012');

        // Assert
        $this->assertSame('123456789012', $instance->getEan());
        $this->assertSame('12349876', $instance->getErpId());
        $this->assertSame('1234', $instance->getSku());
    }
}
