<?php

namespace Src\Sales\Infrastructure\Bling\Responses;

use Src\Sales\Domain\Models\Data\SaleOrdersCollection;
use Src\Integrations\Bling\Base\Responses\BaseResponse;

class Response extends BaseResponse
{
    private array $saleOrders;

    public function __construct(array $data) {
        $this->saleOrders = $data;
    }

    public function data(): array
    {
        return $this->saleOrders;
    }
}
