<?php

namespace Integrations\Bling\Products\Clients;

use Barrigudinha\Product\Clients\Contracts\ProductStore as ProductStoreInterface;
use Exception;
use GuzzleHttp\Exception\ConnectException;
use Integrations\Bling\Products\Requests\GetRequest;
use Integrations\Bling\Products\Requests\ListRequest;
use Integrations\Bling\Products\Requests\PutRequest;
use Integrations\Bling\Products\Responses\BaseResponse;
use Integrations\Bling\Products\Responses\Error;
use Integrations\Bling\Products\Responses\Factories\ErrorResponse;
use Integrations\Bling\Products\Responses\Factories\ProductCollectionResponse;
use Integrations\Bling\Products\Responses\Factories\ProductResponse;
use SimpleXMLElement;

class ProductStore implements ProductStoreInterface
{
    private GetRequest $getRequest;
    private ListRequest $listRequest;
    private PutRequest $putRequest;
    private ProductCollectionResponse $productCollectionResponse;
    private ProductResponse $productResponse;
    private ErrorResponse $errorResponse;

    public function __construct(
        GetRequest $getRequest,
        ListRequest $listRequest,
        PutRequest $putRequest,
        ProductCollectionResponse $productCollectionResponse,
        ProductResponse $productResponse,
        ErrorResponse $errorResponse
    ) {
        $this->getRequest = $getRequest;
        $this->listRequest = $listRequest;
        $this->putRequest = $putRequest;
        $this->productCollectionResponse = $productCollectionResponse;
        $this->productResponse = $productResponse;
        $this->errorResponse = $errorResponse;
    }

    public function get(string $sku, array $stores = []): BaseResponse
    {
        try {
            $productResponse = $this->getRequest->get($sku);
            $storeResponses = [];

            foreach ($stores as $store) {
                $storeResponses[$store] = $this->getRequest->getStore($sku, $store);
            }

            $response = $this->productResponse->make($productResponse, $storeResponses);
        } catch (ConnectException $exception) {
            $message = 'ERRO: ou a conexão de internet está muito instável ou a API do Bling está fora do ar.
            Tente novamente mais tarde.';
            $response = $this->handleError($message);
        } catch (Exception $exception) {
            $response = $this->handleError('Aconteceu algum erro bizarro. Contate o suporte.');
        }

        return $response;
    }

    /**
     * @param int $page
     * @return BaseResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exception
     */
    public function list(int $page = 1): BaseResponse
    {
        try {
            $stores = array_keys(config('stores_code'));
            $responses = [];

            foreach ($stores as $store) {
                $products = $this->listRequest->all($page, $store);
                $responses[] = $this->productCollectionResponse->makeWithStore($products, $store);
            }

            $response = $this->productCollectionResponse->mergeResponses($responses);
        } catch (ConnectException $exception) {
            $message = 'ERRO: ou a conexão de internet está muito instável ou a API do Bling está fora do ar.
            Tente novamente mais tarde.';
            $response = $this->handleError($message);
        } catch (Exception $exception) {
            $error = 'Aconteceu algum erro bizarro. Contate o suporte.';
            $response = $this->handleError($error);
        }

        return $response;
    }

    public function update(string $sku, string $store, string $productStoreSku, float $priceValue): BaseResponse
    {
        try {
            $storeCode = config('stores.' . $store . '.erpCode');

            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><produtosLoja/>');
            $productStore = $xml->addChild('produtoLoja');
            $productStore->addChild('idLojaVirtual', $productStoreSku);
            $price = $productStore->addChild('preco');
            $price->addChild('preco', $priceValue);
            $price->addChild('precoPromocional', $priceValue);

            $product = $this->putRequest->put($sku, $storeCode, $xml->asXML());
            $response = $this->productResponse->make($product, [$store]);
        } catch (ConnectException $exception) {
            $message = 'ERRO: ou a conexão de internet está muito instável ou a API do Bling está fora do ar.
            Tente novamente mais tarde.';
            $response = $this->handleError($message);
        } catch (Exception $exception) {
            $error = 'Aconteceu algum erro bizarro. Contate o suporte.';
            $response = $this->handleError($error);
        }

        return $response;
    }

    private function handleError(string $message): Error
    {
        return $this->errorResponse->make($message);
    }
}
