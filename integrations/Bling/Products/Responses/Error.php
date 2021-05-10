<?php

namespace Integrations\Bling\Products\Responses;

class Error extends BaseResponse
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
