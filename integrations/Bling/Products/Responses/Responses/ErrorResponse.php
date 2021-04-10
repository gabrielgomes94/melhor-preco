<?php

namespace Integrations\Bling\Products\Responses\Responses;

class ErrorResponse extends Response
{
    public function __construct(string $error = null)
    {
        if (isset($error)) {
            $this->errors[] = $error;
        }
    }
}
