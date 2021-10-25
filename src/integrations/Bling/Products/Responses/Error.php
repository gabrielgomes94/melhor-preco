<?php

namespace Src\Integrations\Bling\Products\Responses;

use Src\Integrations\Bling\Products\Responses\BaseResponse;

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
