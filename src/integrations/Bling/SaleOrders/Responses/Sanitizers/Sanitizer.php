<?php

namespace Src\Integrations\Bling\SaleOrders\Responses\Sanitizers;

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

        if (isset($data['retorno']['pedidos'])) {
            $saleOrders = $data['retorno']['pedidos'];

            return array_map(function (array $saleOrder) {
                return $saleOrder['pedido'] ?? [];
            }, $saleOrders);
        }

        return [];
    }
}
