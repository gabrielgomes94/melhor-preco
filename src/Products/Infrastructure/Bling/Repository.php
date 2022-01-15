<?php

namespace Src\Products\Infrastructure\Bling;

use Illuminate\Http\Client\ConnectionException;
use Src\Integrations\Bling\Base\Responses\BaseResponse;
use Src\Integrations\Bling\Products\Client;
use Src\Integrations\Bling\Products\Requests\Config;
use Src\Products\Infrastructure\Bling\Responses\Product\Factory;
use Src\Products\Infrastructure\Bling\Responses\Prices\Factory as PriceFactory;

class Repository
{
    private Client $client;
    private Factory $factory;
    private PriceFactory $priceFactory;

    public function __construct(Client $client, Factory $factory, PriceFactory $priceFactory)
    {
        $this->client = $client;
        $this->factory = $factory;
        $this->priceFactory = $priceFactory;
    }

    public function get(string $sku): BaseResponse
    {
        $response = $this->client->get($sku, Config::ACTIVE);

        return $this->factory->make([$response]);
    }

    public function getOnStore(string $sku, string $store): BaseResponse
    {
        $response = $this->client->get($sku, Config::ACTIVE, $store);

        return $this->factory->make($response);
    }

    public function all()
    {
        $activeProductsCollection = $this->listProducts(Config::ACTIVE);
        $inactiveProductsCollection = $this->listProducts(Config::INACTIVE);

        return array_merge($activeProductsCollection, $inactiveProductsCollection);
    }

    public function allOnStore(string $store)
    {
        $activeProductsCollection = $this->listPricesOnStore($store, Config::ACTIVE);
        $inactiveProductsCollection = $this->listPricesOnStore($store, Config::INACTIVE);

        return array_merge($activeProductsCollection, $inactiveProductsCollection);
    }

    private function listProducts(string $status)
    {
        $page = 0;
        $productsCollection = [];

        do {
            try {
                $response = $this->client->list(page: ++$page, status: $status);
                $products = $this->factory->make($response);
                $productsCollection = array_merge($productsCollection, $products->data());
            } catch (ConnectionException $exception) {
                --$page;
                $products = $this->factory->make([$exception->getMessage()]);

                continue;
            }
        } while (!empty($products->data()));

        return $productsCollection;
    }

    private function listPricesOnStore(string $store, string $status)
    {
        $storeCode = config("stores_code.{$store}");
        $page = 0;
        $pricesCollection = [];

        do {
            try {
                $response = $this->client->listPrice(storeCode: $storeCode, page: ++$page, status: $status);
                $prices = $this->priceFactory->make(storeSlug: $store, data: $response);
                $pricesCollection = array_merge($pricesCollection, $prices->data());
            } catch (ConnectionException $exception) {
                --$page;
                continue;
            }
        } while (!isset($prices) || !empty($prices->data()));

        return $pricesCollection;
    }
}
