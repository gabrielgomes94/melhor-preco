<?php

namespace Src\Integrations\Bling\Invoices\Responses;

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

        if ($this->hasInvoices($data)) {
            return $this->sanitizeInvoice($data);
        }

        return [];
    }

    public function sanitizeMultiple(Response $response): array
    {
        $data = $this->decode($response);

        if ($this->hasError($data)) {
            return $this->sanitizeError($data);
        }

        if ($this->hasInvoices($data)) {
            return $this->sanitizeInvoicesCollection($data);
        }

        return [];
    }

    private function hasInvoices($data): bool
    {
        return isset($data['retorno']['notasfiscais']);
    }

    private function sanitizeInvoice($data): array
    {
        $invoices = array_shift($data['retorno']['notasfiscais']);

        return $invoices['notafiscal'] ?? [];
    }

    private function sanitizeInvoicesCollection($data): array
    {
        return $data['retorno']['notasfiscais'] ?? [];
    }
}
