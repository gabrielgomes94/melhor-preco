<?php

namespace Src\Integrations\Bling\Base\Responses\Sanitizer;

use Illuminate\Http\Client\Response;

abstract class BaseSanitizer
{
    abstract public function sanitize(Response $response): array;

    protected function decode(Response $response)
    {
        return json_decode((string) $response->getBody(), true);
    }

    protected function hasError(array $data): bool
    {
        return isset($data['retorno']['erros']);
    }

    protected function sanitizeError(array $data): array
    {
        $error = array_shift($data['retorno']['erros']);

        if (is_string($error)) {
            return ['error' => $error];
        }

        return ['error' => $error['erro']['msg']];
    }
}
