<?php

namespace Integrations\Bling\Products\Responses\Factories;

use Integrations\Bling\Products\Responses\Error;

class ErrorResponse
{
    public function make(string $error): Error
    {
        return new Error(error: $error);
    }

    public function makeFromData(array $data): Error
    {
        if (empty($data)) {
            return $this->make(error: 'Invalid response!');
        }

        if (isset($data['error'])) {
            return $this->make(error: $data['error']);
        }

        return $this->make(error: 'Invalid ERROR!');
    }
}
