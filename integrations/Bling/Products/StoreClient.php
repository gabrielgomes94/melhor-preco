<?php

namespace Integrations\Bling\Products;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use Integrations\Bling\Products\Responses\Builders\ResponseBuilder as ResponseBuilder;
use Integrations\Bling\Products\Responses\Factory;
use Integrations\Bling\Products\Responses\Responses\Contracts\Response;

class StoreClient
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getWithStores(string $sku, array $stores = []): Response
    {
        $responseBuilder = new ResponseBuilder($this->factory);

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
