<?php

namespace Src\Integrations\Bling\SaleOrders\Responses;

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

        if ($this->hasSaleOrders($data)) {
            return $this->sanitizeSaleOrders($data['retorno']['pedidos']);
        }

        return [];
    }

    private function hasSaleOrders(mixed $data): bool
    {
        return isset($data['retorno']['pedidos']);
    }

    private function sanitizeSaleOrders($pedidos): array
    {
        $saleOrders = $pedidos;

        return array_map(function (array $saleOrder) {
            return $saleOrder['pedido'] ?? [];
        }, $saleOrders);
    }
}
