<?php

namespace Src\Products\Infrastructure\Bling\Responses\Prices;

use Src\Integrations\Bling\Base\Responses\Factories\BaseFactory;

class Factory extends BaseFactory
{
    public function make(string $storeSlug, array $data)
    {
        if ($this->isInvalid($data)) {
            return $this->makeError(data: $data);
        }

        foreach ($data as $product) {
            if (!isset($product['produto']) || !isset($product['produto']['produtoLoja'])) {
                continue;
            }

            if (!$price = Transformer::transform($storeSlug, $product['produto'])) {
                continue;
            }

            $prices[] = $price;
        }

        return new PricesCollectionResponse($prices ?? []);
    }
}
