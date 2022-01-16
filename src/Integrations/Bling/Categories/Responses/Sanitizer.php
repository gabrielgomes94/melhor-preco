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
            // @todo: Log Errors
            return [];
        }

        return $this->sanitizeCategories($data);
    }

    private function sanitizeCategories(mixed $data): array
    {
        $data = $data['retorno']['categorias'] ?? [];

        foreach ($data as $category) {
            $categories[] = $category['categoria'];
        }

        return $categories ?? [];
    }

    private function informationNotFound()
    {
    }
}
