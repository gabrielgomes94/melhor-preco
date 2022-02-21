<?php

namespace Src\Products\Infrastructure\Bling;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Src\Integrations\Bling\Base\Responses\BaseResponse;
use Src\Integrations\Bling\Base\Responses\ErrorResponse;
use Src\Integrations\Bling\Products\Client;
use Src\Integrations\Bling\Products\Requests\Config;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Products\Domain\Repositories\Contracts\Erp\ProductRepository as ErpProductRepositoryInterface;
use Src\Products\Infrastructure\Bling\Responses\Prices\PricesCollectionResponse;
use Src\Products\Infrastructure\Bling\Responses\Product\Factory;
use Src\Products\Infrastructure\Bling\Responses\Prices\Factory as PriceFactory;
use SimpleXMLElement;

class ProductRepository implements ErpProductRepositoryInterface
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

    public function all()
    {
        $activeProductsCollection = $this->listProducts(Config::ACTIVE);
        $inactiveProductsCollection = $this->listProducts(Config::INACTIVE);

        return array_merge($activeProductsCollection, $inactiveProductsCollection);
    }

    public function allInMarketplace(Marketplace $marketplace, string $status, int $page): PricesCollectionResponse
    {
        $response = $this->client->listPrice(
            storeCode: $marketplace->getErpId(),
            page: ++$page,
            status: $status
        );

        return $this->priceFactory->make(
            storeSlug: $marketplace->getSlug(),
            storeCode: $marketplace->getErpId(),
            data: $response
        );
    }

    public function uploadImages(string $sku, string $path, array $images)
    {
        $urls = $this->storeImages($path, $images);

        $updateResponse = $this->client->update($sku, $this->getXML($urls));

        $response = $this->factory->make($updateResponse);

        if ($response instanceof ErrorResponse) {
            Log::error(
                'Produto: Imagens não foram enviadas para o Bling',
                $response->errors()
            );

            throw new \Exception("Erro: produto não foi enviado para o Bling.");
        }
    }

    private function storeImages(string $path, array $images): array
    {
        foreach ($images as $image) {
            $url = Storage::putFileAs($path, $image, $image->getClientOriginalName(), 'public');
            $urls[] = Storage::url(urlencode($url));
        }

        return $urls ?? [];
    }

    private function getXML(array $urls): string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><xml/>');

        $productXML = $xml->addChild('produto');
        $images = $productXML->addChild('imagens');

        foreach ($urls as $url) {
            $images->addChild('url', $url);
        }

        return $xml->asXML();
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
}
