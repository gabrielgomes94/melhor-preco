<?php

namespace Src\Integrations\Bling\Invoices\Responses;

use Illuminate\Http\Client\Response;

class Sanitizer
{
    public function sanitizeMultiple(Response $response): array
    {
        $data = json_decode($response->body(), true);

        if (isset($data['retorno']['erros'])) {
            $error = array_shift($data['retorno']['erros']);

            return ['error' => $error['msg']];
        }

        if (isset($data['retorno']['notasfiscais'])) {
            return $data['retorno']['notasfiscais'];
        }

        return [];
    }
}
