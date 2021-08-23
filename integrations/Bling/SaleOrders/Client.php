<?php

namespace Integrations\Bling\SaleOrders;

use Integrations\Bling\SaleOrders\Requests\ListRequest;

class Client
{
    private ListRequest $listRequest;

    public function __construct(ListRequest $listRequest)
    {
//        dd('asddasadsdsa');
        $this->listRequest = $listRequest;
    }

    public function list()
    {
        $response = $this->listRequest->all();

        dd($response->getBody());
    }
}
