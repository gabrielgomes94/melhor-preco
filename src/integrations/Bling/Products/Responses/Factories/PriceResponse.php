<?php

namespace Src\Integrations\Bling\Products\Responses\Factories;

use Src\Integrations\Bling\Products\Responses\BaseResponse;
use Src\Integrations\Bling\Products\Responses\Price;
use Src\Integrations\Bling\Products\Responses\Transformers\Price as PriceTransformer;
use Illuminate\Http\Client\Response;

class PriceResponse extends BaseFactory
{
    public function make(Response $productResponse, ?string $store = null): BaseResponse
    {
        $data = $this->sanitizer->sanitize($productResponse);

        return new Price(data: PriceTransformer::transform($data));
    }
}
