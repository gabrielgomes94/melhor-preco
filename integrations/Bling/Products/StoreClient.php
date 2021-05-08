<?php

namespace Integrations\Bling\Products;

use Barrigudinha\Product\Clients\Contracts\Client as ProductClient;
use Exception;
use GuzzleHttp\Exception\ConnectException;
use Integrations\Bling\Products\Requests\ListRequest;
use Integrations\Bling\Products\Requests\Request;
use Integrations\Bling\Products\Responses\Builders\ResponseBuilder;
use Integrations\Bling\Products\Responses\Contracts\Response;

class StoreClient
{
    private Request $request;
    private ListRequest $listRequest;

    public function __construct(Request $request, ListRequest $listRequest)
    {
        $this->request = $request;
        $this->listRequest = $listRequest;
    }

    public function get(string $sku, array $stores = []): Response
    {
        return $this->getWithStores($sku, $stores);
    }

    public function list(int $page = 1)
    {
        $responseBuilder = app(ResponseBuilder::class);

        try {
            $responseBuilder->products($this->listRequest->all($page));
        } catch(ConnectException $exception) {
            $error = 'ERRO: ou a conexão de internet está muito instável ou a API do Bling está fora do ar. Tente novamente mais tarde.';
            $responseBuilder->withError($error);
        } catch(Exception $exception) {
            $error = 'Aconteceu algum erro bizarro. Contate o suporte.';
            $responseBuilder->withError($error);
        }

        return $responseBuilder->get();
    }

    public function getWithStores(string $sku, array $stores = []): Response
    {
        $responseBuilder = app(ResponseBuilder::class);

        try {
            $responseBuilder->product($this->request->get($sku));
            foreach($stores as $store) {
                $responseBuilder->withStore($store, $this->request->getStore($sku, $store));
            }
        } catch(ConnectException $exception) {
            $error = 'ERRO: ou a conexão de internet está muito instável ou a API do Bling está fora do ar. Tente novamente mais tarde.';
            $responseBuilder->withError($error);
        } catch(Exception $exception) {
            $error = 'Aconteceu algum erro bizarro. Contate o suporte.';
            $responseBuilder->withError($error);
        }

        return $responseBuilder->get();
    }
}
