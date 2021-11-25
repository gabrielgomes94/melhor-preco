<?php

namespace Src\Products\Infrastructure\Bling\Responses\Product;

use Src\Integrations\Bling\Base\Responses\BaseResponse;
use Src\Products\Domain\Models\Product\Product;

class ProductResponse extends BaseResponse
{
    private array $data;

    public function __construct(array $data)
    {
        foreach ($data as $product) {
            if ($product instanceof Product) {
                $this->data[] = $product;
            }
        }

        $this->data = $data;
    }

    public function data()
    {
        return $this->data;
    }
}
