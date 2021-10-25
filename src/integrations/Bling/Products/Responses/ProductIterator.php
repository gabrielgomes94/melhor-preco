<?php

namespace Src\Integrations\Bling\Products\Responses;

use Src\Integrations\Bling\Products\Responses\BaseResponse;
use Src\Integrations\Bling\Products\Responses\Data\Product;

class ProductIterator extends BaseResponse
{
    /**
     * @param \Src\Integrations\Bling\Products\Responses\Product[] $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return \Src\Integrations\Bling\Products\Responses\Product[]
     */
    public function data(): array
    {
        return $this->data;
    }
}
