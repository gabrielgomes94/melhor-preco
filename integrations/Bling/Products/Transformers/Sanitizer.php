<?php

namespace Integrations\Bling\Products\Transformers;

class Sanitizer
{
    public function sanitize(array $data): array
    {
        if (isset($data['retorno']['erros'])) {
            $error = array_shift($data['retorno']['erros']);

            return ['error' => $error['erro']['msg']];
        }

        if (isset($data['retorno']['produtos'])) {
            $productData = array_shift($data['retorno']['produtos']);
            $product = $productData['produto'];

            return ['product' => $product];
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

            return ['products' => $products];
        }
    }
}
