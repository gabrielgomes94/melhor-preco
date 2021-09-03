<?php

namespace Integrations\Bling\Products\Clients;

use Barrigudinha\Product\Clients\Contracts\ProductStore as ProductStoreInterface;
use Exception;
use GuzzleHttp\Exception\ConnectException;
use Integrations\Bling\Products\Requests\GetRequest;
use Integrations\Bling\Products\Requests\ListRequest;
use Integrations\Bling\Products\Requests\PostRequest;
use Integrations\Bling\Products\Requests\PutRequest;
use Integrations\Bling\Products\Requests\Transformers\ProductStore as ProductStoreTransformer;
use Integrations\Bling\Products\Responses\BaseResponse;
use Integrations\Bling\Products\Responses\Error;
use Integrations\Bling\Products\Responses\Factories\ErrorResponse;
use Integrations\Bling\Products\Responses\Factories\PriceResponse;
use Integrations\Bling\Products\Responses\Factories\ProductCollectionResponse;
use Integrations\Bling\Products\Responses\Factories\ProductResponse;

class ProductStore implements ProductStoreInterface
{
    private GetRequest $getRequest;
    private ListRequest $listRequest;
    private PostRequest $postRequest;
    private PutRequest $putRequest;
    private PriceResponse $priceResponse;
    private ProductCollectionResponse $productCollectionResponse;
    private ProductResponse $productResponse;
    private ErrorResponse $errorResponse;

    public function __construct(
        GetRequest $getRequest,
        ListRequest $listRequest,
        PostRequest $postRequest,
        PutRequest $putRequest,
        PriceResponse $priceResponse,
        ProductCollectionResponse $productCollectionResponse,
        ProductResponse $productResponse,
        ErrorResponse $errorResponse
    ) {
        $this->getRequest = $getRequest;
        $this->listRequest = $listRequest;
        $this->postRequest = $postRequest;
        $this->putRequest = $putRequest;
        $this->priceResponse = $priceResponse;
        $this->productCollectionResponse = $productCollectionResponse;
        $this->productResponse = $productResponse;
        $this->errorResponse = $errorResponse;
    }

    public function get(string $sku, ?string $store = null): BaseResponse
    {
        try {
            if (!$store) {
                $productResponse = $this->getRequest->get($sku);

                return $this->productResponse->make($productResponse);
            }

            $response = $this->getRequest->getStore($sku, $store);

            return $this->productResponse->make($response, $store);
        } catch (ConnectException $exception) {
            $response = $this->handleError($this->connectionErrorMessage());
        } catch (Exception $exception) {
            $response = $this->handleError($this->bizarreErrorMessage());
        }

        return $response;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exception
     */
    public function list(int $page = 1, ?string $store = null): BaseResponse
    {
        try {
            $products = $this->listRequest->all($page, $store);

            if (!$store) {
                return $this->productCollectionResponse->make($products);
            }

            $response = $this->productCollectionResponse->makeWithStore($products, $store);
        } catch (ConnectException $exception) {
            $response = $this->handleError($this->connectionErrorMessage());
        } catch (Exception $exception) {
            $response = $this->handleError($this->bizarreErrorMessage());
        }

        return $response;
    }

    public function update(string $sku, string $xml)
    {
        try {
            $response = $this->postRequest->post($sku, $xml);
            return $this->productResponse->make($response);
        } catch (ConnectException $exception) {
            $response = $this->handleError($this->connectionErrorMessage());
        } catch (Exception $exception) {
            $response = $this->handleError($this->bizarreErrorMessage());
        }

        return $response ?? '';
    }

    /**
     * ToDo: Renomear esse método para updatePrice
     */
    public function updatePrice(string $sku, string $store, string $productStoreSku, string $priceValue): BaseResponse
    {
        try {
            $storeCode = config('stores.' . $store . '.erpCode');
            $xml = ProductStoreTransformer::generateXML($productStoreSku, $priceValue);
            $product = $this->putRequest->put($sku, $storeCode, $xml);

            $response = $this->priceResponse->make($product, $store);
        } catch (ConnectException $exception) {
            $response = $this->handleError($this->connectionErrorMessage());
        } catch (Exception $exception) {
            $response = $this->handleError($this->bizarreErrorMessage());
        }

        return $response;
    }

    private function handleError(string $message): Error
    {
        return $this->errorResponse->make($message);
    }

    private function connectionErrorMessage(): string
    {
        return 'ERRO: ou a conexão de internet está muito instável ou a API do Bling está fora do ar. Tente novamente mais tarde.';
    }

    private function bizarreErrorMessage(): string
    {
        return 'Aconteceu algum erro bizarro. Contate o suporte.';
    }
}
