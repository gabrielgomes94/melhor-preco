<?php

namespace Integrations\Bling\Products\Responses\Sanitizers;

class Sanitizer
{
    public function sanitize(array $data): array
    {
        if (isset($data['retorno']['erros'])) {
            $error = array_shift($data['retorno']['erros']);

            if (is_string($error)) {
                return ['error' => $error];
            }

            return ['error' => $error['erro']['msg']];
        }

        if (isset($data['retorno']['produtos'])) {
            $productData = array_shift($data['retorno']['produtos']);
            $product = $productData['produto'];

            return $product;
        }

        return [];
    }

    public function sanitizeMultiple(array $data): array
    {
        if (isset($data['retorno']['erros'])) {
            $error = array_shift($data['retorno']['erros']);

            return ['error' => $error['erro']['msg']];
        }

        if (isset($data['retorno']['produtos'])) {
            $products = $data['retorno']['produtos'];

            return $products;
        }
    }
}
