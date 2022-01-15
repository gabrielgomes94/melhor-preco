<?php

namespace Src\Integrations\Bling\Categories\Responses;

use Illuminate\Http\Client\Response;
use Src\Integrations\Bling\Base\Responses\Sanitizer\BaseSanitizer;

class Sanitizer extends BaseSanitizer
{
    public function sanitize(Response $response): array
    {
        $data = $this->decode($response);

        if ($this->hasError($data)) {
            return $this->sanitizeError($data);
        }

        return $data['retorno']['categorias'] ?? [];
    }
}
