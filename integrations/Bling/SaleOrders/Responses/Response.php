<?php

namespace Integrations\Bling\SaleOrders\Responses;

use Barrigudinha\SaleOrder\Entities\SaleOrdersCollection;
use Integrations\Bling\Base\Responses\BaseResponse;

class Response extends BaseResponse
{
    private SaleOrdersCollection $saleOrder;

    public function __construct(SaleOrdersCollection $data) {
        $this->saleOrder = $data;
    }

    public function data(): SaleOrdersCollection
    {
        return $this->saleOrder;
    }
}
