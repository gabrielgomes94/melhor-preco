<?php

namespace Integrations\Bling\Products\Clients;

use Exception;
use GuzzleHttp\Exception\ConnectException;
use Integrations\Bling\Products\Requests\GetRequest;
use Integrations\Bling\Products\Requests\ListRequest;
use Integrations\Bling\Products\Responses\BaseResponse;
use Integrations\Bling\Products\Responses\Error;
use Integrations\Bling\Products\Responses\Factories\ErrorResponse;
use Integrations\Bling\Products\Responses\Factories\ProductCollectionResponse;
use Integrations\Bling\Products\Responses\Factories\ProductResponse;

class ProductStore
{
    private GetRequest $getRequest;
    private ListRequest $listRequest;
    private ProductCollectionResponse $productCollectionResponse;
    private ProductResponse $productResponse;
    private ErrorResponse $errorResponse;

    public function __construct(
        GetRequest $getRequest,
        ListRequest $listRequest,
        ProductCollectionResponse $productCollectionResponse,
        ProductResponse $productResponse,
        ErrorResponse $errorResponse
    ) {
        $this->getRequest = $getRequest;
        $this->listRequest = $listRequest;
        $this->productCollectionResponse = $productCollectionResponse;
        $this->productResponse = $productResponse;
        $this->errorResponse = $errorResponse;
    }

    /**
     * @param string[] $stores
     *
     * @return BaseResponse
     */
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
            $products = $this->listRequest->all($page);
            $response = $this->productCollectionResponse->make($products);
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
