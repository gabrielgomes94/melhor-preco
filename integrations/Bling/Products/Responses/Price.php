<?php

namespace Integrations\Bling\Products\Responses;

use Integrations\Bling\Products\Responses\Data\Price as PriceData;

class Price extends BaseResponse
{
    protected PriceData $product;

    public function __construct(PriceData $data)
    {
        $this->product = $data;
    }

    public function data(): PriceData
    {
        return $this->product;
    }
}
