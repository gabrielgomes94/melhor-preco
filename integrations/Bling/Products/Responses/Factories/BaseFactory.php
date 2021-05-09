<?php

namespace Integrations\Bling\Products\Responses\Factories;

use Integrations\Bling\Products\Transformers\Sanitizer;
use Integrations\Bling\Products\Transformers\Transformer;

class BaseFactory
{
    protected Sanitizer $sanitizer;
    protected ErrorResponse $error;
    protected Transformer $transformer;

    public function __construct(Sanitizer $sanitizer, ErrorResponse $error, Transformer $transformer)
    {
        $this->sanitizer = $sanitizer;
        $this->error = $error;
        $this->transformer = $transformer;
    }

    protected function isInvalid(array $data): bool
    {
        return empty($data) || isset($data['error']);
    }
}
