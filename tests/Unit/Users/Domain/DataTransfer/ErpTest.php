<?php

namespace Src\Users\Domain\DataTransfer;

use PHPUnit\Framework\TestCase;

class ErpTest extends TestCase
{
    public function test_should_instantiate_erp(): void
    {
        // Act
        $instance = new Erp('token', 'bling');

        // Assert
        $this->assertSame('token', $instance->token);
        $this->assertSame('bling', $instance->name);
    }
}
