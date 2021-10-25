<?php

namespace Src\Integrations\Bling\Products\Responses\Factories;

use Src\Integrations\Bling\Products\Responses\Factories\ErrorResponse;
use Src\Integrations\Bling\Products\Responses\Sanitizers\Sanitizer;

class BaseFactory
{
    protected Sanitizer $sanitizer;
    protected ErrorResponse $errorResponse;

    public function __construct(Sanitizer $sanitizer, ErrorResponse $errorResponse)
    {
        $this->sanitizer = $sanitizer;
        $this->errorResponse = $errorResponse;
    }

    protected function isInvalid(array $data): bool
    {
        return empty($data) || isset($data['error']);
    }
}
