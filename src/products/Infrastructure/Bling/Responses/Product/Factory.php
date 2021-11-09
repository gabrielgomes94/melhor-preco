<?php

namespace Src\Products\Infrastructure\Bling\Responses\Product;

use Src\Integrations\Bling\Base\Responses\Factories\BaseFactory;

class Factory extends BaseFactory
{
    public function make(array $data)
    {
        if ($this->isInvalid($data)) {
            return $this->makeError(data: $data);
        }

        foreach ($data as $product) {
            if (!isset($product['produto'])) {
                continue;
            }

            $products[] = Transformer::transform($product['produto']);
        }

        return new ProductResponse($products ?? []);
    }
}
