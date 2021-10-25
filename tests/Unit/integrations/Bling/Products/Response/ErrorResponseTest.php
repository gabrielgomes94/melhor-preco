<?php

namespace Tests\Unit\Integrations\Bling\Products\Response;

use Src\Integrations\Bling\Products\Responses\Error;
use Tests\TestCase;

class ErrorResponseTest extends TestCase
{
    public function testShouldCreateProductErrorResponse(): void
    {
        // Act
        $result = new Error(error: 'Invalid product response.');

        // Assert
        $this->assertNull($result->product());
        $this->assertSame(['Invalid product response.'], $result->errors());
        $this->assertTrue($result->hasErrors());
    }

}
