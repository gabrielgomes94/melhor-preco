<?php

namespace Integrations\Bling\Products;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use Integrations\Bling\Products\Requests\Request;
use Integrations\Bling\Products\Responses\ResponseBuilder;
use Integrations\Bling\Products\Responses\Contracts\Response;

class StoreClient
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
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
