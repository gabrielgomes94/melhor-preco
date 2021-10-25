<?php

namespace Src\Integrations\Bling\SaleOrders\Responses;

use Src\Sales\Domain\Models\SaleOrdersCollection;
use Illuminate\Http\Client\Response;
use Src\Integrations\Bling\Base\Responses\Factories\BaseFactory;
use Src\Integrations\Bling\SaleOrders\Responses\Sanitizers\Sanitizer;
use Src\Integrations\Bling\SaleOrders\Responses\Transformers\SaleOrderTransformer;

class ResponseFactory extends BaseFactory
{
    private Sanitizer $sanitizer;

    public function __construct(Sanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    public function make(Response $response)
    {
        $data = $this->sanitizer->sanitize($response);

        if ($this->isInvalid($data)) {
            return $this->makeError(data: $data);
        }

        foreach ($data as $saleOrder) {
            $saleOrders[] = SaleOrderTransformer::transform($saleOrder);
        }

        return new \Src\Integrations\Bling\SaleOrders\Responses\SaleOrderResponse(
            data: new SaleOrdersCollection($saleOrders ?? [])
        );
    }

}
