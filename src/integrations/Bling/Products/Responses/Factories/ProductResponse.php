<?php

namespace Src\Integrations\Bling\Products\Responses\Factories;

use Src\Integrations\Bling\Products\Responses\BaseResponse;
use Src\Integrations\Bling\Products\Responses\Data\Product as ProductData;
use Src\Integrations\Bling\Products\Responses\Product;
use Src\Integrations\Bling\Products\Responses\Transformers\Product as ProductTransformer;
use Psr\Http\Message\ResponseInterface;
use Src\Integrations\Bling\Products\Responses\Factories\BaseFactory;

class ProductResponse extends BaseFactory
{
    /**
     * @param array<string, ResponseInterface> $stores
     */
    public function make(ResponseInterface $productResponse, ?string $store = null): BaseResponse
    {
        $data = $this->sanitizer->sanitize($productResponse);

        if ($this->isInvalid($data)) {
            return $this->errorResponse->makeFromData(data: $data);
        }

        if ($store) {
            return new Product(data: ProductTransformer::transformWithStore($data, $store));
        }

        return new Product(data: ProductTransformer::transform($data));
    }


    public function makeStores(array $stores)
    {
        $productData = $this->getStoreData($stores);

        if (!$productData) {
            return $this->errorResponse->make('Erro!!!!');
        }

        return new Product(data: $productData);
    }

    private function getStoreData(array $stores): ProductData
    {
        $product = $stores[0];

        for ($i = 1; $i < count($stores); $i++) {
            $product->addStore($stores[$i]->stores()[0]);
        }

        return $product;
    }
}
