<?php

namespace Integrations\Bling\Products\Repositories;

use Integrations\Bling\Products\Clients\ProductStore;
use Integrations\Bling\Products\Responses\Contracts\Response;
use Integrations\Bling\Products\Responses\Data\ProductsCollection;
use Integrations\Bling\Products\Responses\Factories\ProductCollectionResponse;
use Integrations\Bling\Products\Responses\Factories\ProductResponse;
use Integrations\Bling\Products\Responses\ProductIterator;

class Repository
{
    private ProductStore $client;
    private ProductResponse $productResponse;
    private ProductCollectionResponse $productCollectionResponse;

    public function __construct(ProductStore $client, ProductResponse $productResponse, ProductCollectionResponse $productCollectionResponse)
    {
        $this->client = $client;
        $this->productResponse = $productResponse;
        $this->productCollectionResponse = $productCollectionResponse;
    }

    public function get(string $sku, array $stores = []): Response
    {
        if (!$stores) {
            $response = $this->client->get($sku);

            return $this->productResponse->make($response);
        }

        foreach ($stores as $store) {
            $storeResponses[] = $this->client->get($sku, $store)->data();
        }

        return $this->productResponse->makeStores($storeResponses ?? []);
    }

    public function all(): ProductIterator
    {
        $productsCollection = $this->getProductCollection()->toArray();

        return new ProductIterator(data: $productsCollection);
    }


    private function getProductCollection(): ProductsCollection
    {
        $page = 0;
        $productsCollection = new ProductsCollection();

        do {
            $stores = array_keys(config('stores_code'));
            $products = $this->client->list($page++)->data();
            $productsCollection->addProducts($products);

            foreach ($stores as $store) {
                $productsStore = $this->client->list($page, $store)->data();
                $productsCollection->addStores($productsStore);
            }
        } while (!empty($products));

        return $productsCollection ?? [];
    }
}
