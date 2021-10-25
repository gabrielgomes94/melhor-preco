<?php

namespace Src\Integrations\Bling\Products\Responses\Sanitizers;

use Psr\Http\Message\ResponseInterface;

class Sanitizer
{
    public function sanitize(ResponseInterface $response): array
    {
        $data = json_decode((string) $response->getBody(), true);

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

        if (isset($data['retorno']['produtosLoja'])) {
            $productData = array_shift($data['retorno']['produtosLoja']);
            $productData = array_shift($productData);
            $product = $productData['produtoLoja'];

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
