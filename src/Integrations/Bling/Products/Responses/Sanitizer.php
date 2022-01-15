<?php

namespace Src\Integrations\Bling\Products\Responses;

use Illuminate\Http\Client\Response;

class Sanitizer
{
    public function sanitize(Response $response): array
    {
        $data = json_decode($response->body(), true);

        if (isset($data['retorno']['erros'])) {
            $error = array_shift($data['retorno']['erros']);

            return ['error' => $error['msg']];
        }

        if (isset($data['retorno']['produtos'])) {
            $productData = array_shift($data['retorno']['produtos']);

            return $productData;
        }

        if (isset($data['retorno']['produtosLoja'])) {
            $productData = array_shift($data['retorno']['produtosLoja']);
            $productData = array_shift($productData);

            return $productData;
        }

        return [];
    }

    public function sanitizeMultiple(Response $response): array
    {
        $data = json_decode($response->body(), true);

        if (isset($data['retorno']['erros'])) {
            $error = array_shift($data['retorno']['erros']);

            if (isset($error['erro'])) {
                return ['error' => $error['erro']['msg']];
            }

            return ['error' => $error['msg']] ;
        }

        if (isset($data['retorno']['produtos'])) {
            $products = $data['retorno']['produtos'];

            return $products;
        }
    }
}
