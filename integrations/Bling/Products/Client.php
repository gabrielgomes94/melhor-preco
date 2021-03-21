<?php

namespace Integrations\Bling\Products;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use Integrations\Bling\Products\Response\Factory;

use Integrations\Bling\Products\Response\ProductResponse;

class Client
{
    private Factory $factory;

    private GuzzleClient $httpClient;

    private array $options;

    public function __construct(Factory $factory, GuzzleClient $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->options = [
            'base_uri' => 'https://Bling.com.br/Api/v2/produto/',
            'query' => [
                'apikey' => env('BLING_API_KEY'),
                'estoque' => 'S',
                'imagem' => 'S',
            ],
        ];

        $this->factory = $factory;
    }

    public function get(string $sku): ProductResponse
    {
        $uri = $this->uri($sku);

        try {
            $response = $this->httpClient->request('GET', $uri, $this->options);
            dd((string) $response->getBody());
            $product = $this->factory->make($response);

        } catch(ConnectException $exception) {
            $error = 'ERRO: ou a conexão de internet está muito instável ou a API do Bling está fora do ar. Tente novamente mais tarde.';
            $product = $this->factory->makeWithError($error);

        } catch(Exception $exception) {
            $error = 'Aconteceu algum erro bizarro. Contate o suporte.';
            $product = $this->factory->makeWithError($error);
        }

        return $product;
    }

    private function uri(string $sku): string
    {
        return "{$sku}/json";
    }
}
