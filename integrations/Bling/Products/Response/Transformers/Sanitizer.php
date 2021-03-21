<?php

namespace Integrations\Bling\Products\Response\Transformers;

class Sanitizer
{
    public function sanitize(array $data): array
    {
        $transformedData = [];

        if (isset($data['retorno']['erros'])) {
            $error = array_shift($data['retorno']['erros']);

            $transformedData = ['error' => $error['erro']];
        }

        if (isset($data['retorno']['produtos'])) {
            $product = $data['retorno']['produtos'][0]['produto'];

            $transformedData = ['product' => $product];
        }

        return $transformedData;
    }
}
