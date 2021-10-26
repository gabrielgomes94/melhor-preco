<?php

namespace Src\Integrations\Bling\SaleOrders\Responses;

use Src\Sales\Domain\Models\SaleOrdersCollection;
use Src\Integrations\Bling\Base\Responses\BaseResponse;

class Response extends \Src\Integrations\Bling\Base\Responses\BaseResponse
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
