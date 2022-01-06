<?php

namespace Src\Integrations\Bling\Base\Responses;

use Src\Integrations\Bling\Base\Responses\BaseResponse;

class ErrorResponse extends BaseResponse
{
    public function __construct(string $error = null)
    {
        $this->error= $error;
        if (isset($error)) {
            $this->errors[] = $error;
        }
    }

    public function getErrorMessage(): string
    {
        return $this->error;
    }

    public function data(): array
    {
        return [];
    }
}
