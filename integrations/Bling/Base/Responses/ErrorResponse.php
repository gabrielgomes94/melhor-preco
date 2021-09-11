<?php

namespace Integrations\Bling\Base\Responses;

class ErrorResponse extends BaseResponse
{
    public function __construct(string $error = null)
    {
        if (isset($error)) {
            $this->errors[] = $error;
        }
    }

    public function data(): array
    {
        return [];
    }
}
