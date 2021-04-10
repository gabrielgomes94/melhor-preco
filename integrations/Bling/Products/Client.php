<?php

namespace Integrations\Bling\Products;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use Integrations\Bling\Products\Responses\Factory;

use Integrations\Bling\Products\Responses\ProductResponse;

class Client
{
    protected Factory $factory;

    protected GuzzleClient $httpClient;

    protected array $options;

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
        try {
            $response = $this->httpClient->request('GET', $this->uri($sku), $this->options);
            $product = $this->factory->make(response: $response);

        } catch(ConnectException $exception) {
            $error = 'ERRO: ou a conexão de internet está muito instável ou a API do Bling está fora do ar. Tente novamente mais tarde.';
            $product = $this->factory->makeError(error: $error);

        } catch(Exception $exception) {
            $error = 'Aconteceu algum erro bizarro. Contate o suporte.';
            $product = $this->factory->makeError(error: $error);
        }

        return $product;
    }

    protected function uri(string $sku): string
    {
        return "{$sku}/json";
    }
}
