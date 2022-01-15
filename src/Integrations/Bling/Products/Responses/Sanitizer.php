<?php

namespace Src\Integrations\Bling\Products\Responses;

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

        if ($this->hasProducts($data)) {
            return $this->sanitizeProducts($data);
        }

        if ($this->hasProductStores($data)) {
            return $this->sanitizeProductStores($data);
        }

        return [];
    }

    public function sanitizeMultiple(Response $response): array
    {
        $data = $this->decode($response);

        if ($this->hasError($data)) {
            return $this->sanitizeError($data);
        }

        if ($this->hasProducts($data)) {
            return $this->sanitizeProductsCollection($data);
        }

        return [];
    }

    private function hasProducts(array $data): bool
    {
        return isset($data['retorno']['produtos']);
    }

    private function hasProductStores(array $data): bool
    {
        return isset($data['retorno']['produtosLoja']);
    }

    private function sanitizeProducts(array $data): array
    {
        $productData = array_shift($data['retorno']['produtos']);

        return $productData ?? [];
    }

    private function sanitizeProductStores(array $data): array
    {
        $productData = array_shift($data['retorno']['produtosLoja']);
        $productData = array_shift($productData);

        return $productData ?? [];
    }

    private function sanitizeProductsCollection(array $data)
    {
        return $data['retorno']['produtos'] ?? [];
    }
}
