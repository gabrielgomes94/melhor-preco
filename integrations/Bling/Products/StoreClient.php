<?php

namespace Integrations\Bling\Products;


use Exception;
use GuzzleHttp\Exception\ConnectException;
use Integrations\Bling\Products\Requests\ListRequest;
use Integrations\Bling\Products\Requests\GetRequest;
use Integrations\Bling\Products\Responses\BaseResponse;
use Integrations\Bling\Products\Responses\Builders\ResponseBuilder;
use Integrations\Bling\Products\Responses\Contracts\Response;
use Integrations\Bling\Products\Responses\Error;
use Integrations\Bling\Products\Responses\Factories\ErrorResponse;
use Integrations\Bling\Products\Responses\Factories\ProductCollectionResponse;
use Integrations\Bling\Products\Responses\Factories\ProductResponse;

class StoreClient
{
    private GetRequest $request;
    private ListRequest $listRequest;
    private ProductResponse $productResponse;
    private ProductCollectionResponse $productCollectionResponse;
    private ErrorResponse $errorResponse;

    public function __construct(GetRequest $request, ListRequest $listRequest, ProductResponse $productResponse, ErrorResponse $errorResponse, ProductCollectionResponse $productCollectionResponse)
    {
        $this->request = $request;
        $this->listRequest = $listRequest;
        $this->productResponse = $productResponse;
        $this->errorResponse = $errorResponse;
        $this->productCollectionResponse = $productCollectionResponse;
    }

    public function list(int $page = 1): BaseResponse
    {
        try {
            $products = $this->listRequest->all($page);
            $response = $this->productCollectionResponse->make($products);
        } catch(ConnectException $exception) {
            $error = 'ERRO: ou a conexão de internet está muito instável ou a API do Bling está fora do ar. Tente novamente mais tarde.';
            $response = $this->handleError($error);
        } catch(Exception $exception) {
            $error = 'Aconteceu algum erro bizarro. Contate o suporte.';
            $response = $this->handleError($error);
        }

        return $response;
    }

    public function get(string $sku, array $stores = []): Response
    {
        try {
            $productResponse = $this->request->get($sku);
            $storeResponses = [];

            foreach($stores as $store) {
                $storeResponses[$store] = $this->request->getStore($sku, $store);
            }

            $response = $this->productResponse->make($productResponse, $storeResponses);
        } catch(ConnectException $exception) {
            $response = $this->handleError('ERRO: ou a conexão de internet está muito instável ou a API do Bling está fora do ar. Tente novamente mais tarde.');
        } catch(Exception $exception) {
            $response = $this->handleError('Aconteceu algum erro bizarro. Contate o suporte.');
        }

        return $response;
    }

    private function handleError(string $message): Error
    {
        return $this->errorResponse->make($message);
    }
}
