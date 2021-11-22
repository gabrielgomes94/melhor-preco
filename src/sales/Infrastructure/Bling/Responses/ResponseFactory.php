<?php

namespace Src\Sales\Infrastructure\Bling\Responses;

use Illuminate\Support\Facades\Log;
use Src\Integrations\Bling\Base\Responses\Factories\BaseFactory;
use Src\Sales\Infrastructure\Bling\Responses\Transformers\Transformer;

class ResponseFactory extends BaseFactory
{
    public function make(array $data)
    {
        if ($this->isInvalid($data)) {
            return $this->makeError(data: $data);
        }

        foreach ($data as $saleOrder) {
            Log::debug('Sale Order: ', $saleOrder);
            $saleOrders[] = $s = Transformer::transform($saleOrder);
        }

        return new Response($saleOrders);
    }
}
