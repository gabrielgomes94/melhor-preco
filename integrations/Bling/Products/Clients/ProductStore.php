<?php

namespace Integrations\Bling\Products\Clients;

use Barrigudinha\Product\Clients\Contracts\ProductStore as ProductStoreInterface;
use Exception;
use GuzzleHttp\Exception\ConnectException;
use Integrations\Bling\Products\Requests\GetRequest;
use Integrations\Bling\Products\Requests\ListRequest;
use Integrations\Bling\Products\Requests\PutRequest;
use Integrations\Bling\Products\Requests\Transformers\ProductStore as ProductStoreTransformer;
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

    public function update(string $sku, string $store, string $productStoreSku, string $priceValue): BaseResponse
    {
        try {
            $storeCode = config('stores.' . $store . '.erpCode');
            $xml = ProductStoreTransformer::generateXML($productStoreSku, $priceValue);
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

    private function connectionErrorMessage(): string
    {
        return 'ERRO: ou a conexão de internet está muito instável ou a API do Bling está fora do ar. Tente novamente mais tarde.';
    }

    private function bizarreErrorMessage():  string
    {
        return 'Aconteceu algum erro bizarro. Contate o suporte.';
    }
}
