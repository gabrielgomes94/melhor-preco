<?php

namespace Integrations\Bling\Products\Responses\Factories;

use Integrations\Bling\Products\Responses\Data\Product as ProductData;
use Integrations\Bling\Products\Responses\Product;
use Integrations\Bling\Products\Responses\Transformers\Product as ProductTransformer;
use Integrations\Bling\Products\Responses\Transformers\Store as StoreTransformer;
use Psr\Http\Message\ResponseInterface;

class ProductResponse extends BaseFactory
{
    /**
     * @param array<string, ResponseInterface> $stores
     */
    public function make(ResponseInterface $productResponse, ?string $store = null): Product
    {
        $data = $this->getData($productResponse);

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

        for ($i = 1;  $i < count($stores); $i++) {
            $product->addStore($stores[$i]->stores()[0]);
        }

        return $product;
    }


    private function getData(ResponseInterface $response): array
    {
        $data = json_decode((string) $response->getBody(), true);
        $data = $this->sanitizer->sanitize($data);

        return  $data;
    }
}
