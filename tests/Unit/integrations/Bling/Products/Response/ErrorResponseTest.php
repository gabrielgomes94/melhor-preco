<?php

namespace Tests\Unit\Integrations\Bling\Products\Response;

use Integrations\Bling\Products\Responses\ErrorResponse;
use Tests\TestCase;

class ErrorResponseTest extends TestCase
{
    public function testShouldCreateProductErrorResponse(): void
    {
        // Act
        $result = new ErrorResponse(error: 'Invalid product response.');

        // Assert
        $this->assertNull($result->product());
        $this->assertSame(['Invalid product response.'], $result->errors());
        $this->assertTrue($result->hasErrors());
    }

}
