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

class Product
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

    public function get(string $sku): BaseResponse
    {
        try {
            $productResponse = $this->getRequest->get($sku);
            $response = $this->productResponse->make($productResponse);
        } catch (ConnectException $exception) {
            $msg = 'ERRO: ou a conexão de internet está muito instável ou a API do Bling está fora do ar.
            Tente novamente mais tarde.';
            $response = $this->handleError($msg);
        } catch (Exception $exception) {
            $response = $this->handleError('Aconteceu algum erro bizarro. Contate o suporte.');
        }

        return $response;
    }

    private function handleError(string $message): Error
    {
        return $this->errorResponse->make($message);
    }
}
