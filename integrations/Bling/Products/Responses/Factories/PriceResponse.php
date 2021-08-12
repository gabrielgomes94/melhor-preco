<?php

namespace Integrations\Bling\Products\Responses\Factories;

use Integrations\Bling\Products\Responses\BaseResponse;
use Integrations\Bling\Products\Responses\Price;
use Integrations\Bling\Products\Responses\Transformers\Price as PriceTransformer;
use Psr\Http\Message\ResponseInterface;

class PriceResponse extends BaseFactory
{
    public function make(ResponseInterface $productResponse, ?string $store = null): BaseResponse
    {
        $data = $this->sanitizer->sanitize($productResponse);

        return new Price(data: PriceTransformer::transform($data));
    }
}
