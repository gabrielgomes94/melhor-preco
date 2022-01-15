<?php

namespace Src\Integrations\Bling\Invoices\Responses;

use Illuminate\Http\Client\Response;

class Sanitizer
{
    public function sanitize(Response $response): array
    {
        $data = json_decode($response->body(), true);

        if (isset($data['retorno']['erros'])) {
            $error = array_shift($data['retorno']['erros']);

            return ['error' => $error['erro']['msg'] ?? null];
        }

        if (isset($data['retorno']['notasfiscais'])) {
            $invoices = array_shift($data['retorno']['notasfiscais']);

            return $invoices['notafiscal'];
        }

        return [];
    }

    public function sanitizeMultiple(Response $response): array
    {
        $data = json_decode($response->body(), true);

        if (isset($data['retorno']['erros'])) {
            $error = array_shift($data['retorno']['erros']);
            $message = $error['erro']['msg'] ?? '';

            return ['error' => $message];
        }

        if (isset($data['retorno']['notasfiscais'])) {
            return $data['retorno']['notasfiscais'];
        }

        return [];
    }
}
