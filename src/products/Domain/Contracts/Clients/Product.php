<?php

namespace Src\Products\Domain\Contracts\Clients;

use Src\Integrations\Bling\Products\Responses\BaseResponse;

interface Product
{
    public function get(string $sku): BaseResponse;
}
