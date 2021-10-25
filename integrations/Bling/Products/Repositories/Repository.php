<?php

namespace Integrations\Bling\Products\Repositories;

use Integrations\Bling\Products\Clients\ProductStore;
use Integrations\Bling\Products\Repositories\Contracts\Repository as RepositoryInterface;
use Integrations\Bling\Products\Responses\Contracts\Response;
use Integrations\Bling\Products\Responses\Data\ProductsCollection;
use Integrations\Bling\Products\Responses\Factories\ProductResponse;
use Integrations\Bling\Products\Responses\ProductIterator;
use Src\Products\Application\Services\ListProducts;
use Src\Products\Infrastructure\Repositories\Options\NullOptions;

class Repository implements RepositoryInterface
{
    private ListProducts $listProductsService;
    private ProductStore $client;
    private ProductResponse $productResponse;

    public function __construct(
        ListProducts $listProductsService,
        ProductStore $client,
        ProductResponse $productResponse
    ) {
        $this->client = $client;
        $this->productResponse = $productResponse;
        $this->listProductsService = $listProductsService;
    }

    public function all(array $stores = []): ProductIterator
    {
        $productsCollection = $this->getProductCollection($stores)->toArray();

        return new ProductIterator(data: $productsCollection);
    }

    public function get(string $sku, array $stores = []): Response
    {
        if (!$stores) {
            return $this->client->get($sku);
        }

        foreach ($stores as $store) {
            $storeResponses[] = $this->client->get($sku, $store)->data();
        }

        return $this->productResponse->makeStores($storeResponses ?? []);
    }

    private function getProductCollection(array $stores = []): ProductsCollection
    {
        $page = 0;
        $productsCollection = new ProductsCollection();

        $totalCount = $this->listProductsService->count(new NullOptions());

        do {
            $stores = $stores ?: array_keys(config('stores_code'));
            $products = $this->client->list(++$page)->data();
            $productsCollection->addProducts($products);

            foreach ($stores as $store) {
                $productsStore = $this->client->list($page, $store)->data();
                $productsCollection->addStores($productsStore);
            }
        } while (!empty($products) && $productsCollection->count() < $totalCount);

        return $productsCollection ?? [];
    }
}
