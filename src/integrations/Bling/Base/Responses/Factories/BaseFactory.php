<?php

namespace Src\Integrations\Bling\Base\Responses\Factories;

use Src\Integrations\Bling\Base\Responses\ErrorResponse;

class BaseFactory
{
    protected function makeError(array $data): ErrorResponse
    {
        if (empty($data)) {
            return new ErrorResponse(error: 'Invalid response!');
        }

        if (isset($data['error'])) {
            return new ErrorResponse(error: $data['error']);
        }

        return new ErrorResponse(error: 'Invalid ERROR!');
    }

    protected function isInvalid(array $data): bool
    {
        return empty($data) || isset($data['error']);
    }
}
