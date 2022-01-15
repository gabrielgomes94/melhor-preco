<?php

namespace Src\Products\Infrastructure\Bling\Responses\Prices;

use Src\Integrations\Bling\Base\Responses\BaseResponse;
use Src\Prices\Domain\Models\Price;

class PricesCollectionResponse extends BaseResponse
{
    private array $data;

    public function __construct(array $data)
    {
        foreach ($data as $price) {
            if ($price instanceof Price) {
                $this->data[] = $price;
            }
        }
    }

    public function data()
    {
        return $this->data ?? [];
    }
}
