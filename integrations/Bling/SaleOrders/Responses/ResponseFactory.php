<?php

namespace Integrations\Bling\SaleOrders\Responses;

use Barrigudinha\SaleOrder\Entities\SaleOrdersCollection;
use Illuminate\Http\Client\Response;
use Integrations\Bling\Base\Responses\Factories\BaseFactory;
use Integrations\Bling\SaleOrders\Responses\Response as SaleOrderResponse;
use Integrations\Bling\SaleOrders\Responses\Sanitizers\Sanitizer;
use Integrations\Bling\SaleOrders\Responses\Transformers\SaleOrderTransformer;

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

        return new SaleOrderResponse(
            data: new SaleOrdersCollection($saleOrders ?? [])
        );
    }

}
