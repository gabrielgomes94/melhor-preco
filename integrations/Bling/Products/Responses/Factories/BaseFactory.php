<?php

namespace Integrations\Bling\Products\Responses\Factories;

use Integrations\Bling\Products\Transformers\Sanitizer;
use Integrations\Bling\Products\Transformers\Transformer;

class BaseFactory
{
    protected Sanitizer $sanitizer;
    protected ErrorResponse $errorResponse;
    protected Transformer $transformer;

    public function __construct(Sanitizer $sanitizer, ErrorResponse $errorResponse, Transformer $transformer)
    {
        $this->sanitizer = $sanitizer;
        $this->errorResponse = $errorResponse;
        $this->transformer = $transformer;
    }

    protected function isInvalid(array $data): bool
    {
        return empty($data) || isset($data['error']);
    }
}
