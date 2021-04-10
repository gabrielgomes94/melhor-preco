<?php

namespace Integrations\Bling\Products;

use GuzzleHttp\Client as GuzzleClient;
use Integrations\Bling\Products\Contracts\Request as RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Request implements RequestInterface
{
    protected GuzzleClient $httpClient;

    protected array $options;

    public function __construct(GuzzleClient $httpClient)
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
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $sku): ResponseInterface
    {
        return $this->httpClient->request('GET', $this->uri($sku), $this->options);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getStore(string $sku, string $store): ResponseInterface
    {
        $options = $this->options;
        $options['query']['loja'] = config("stores_code.{$store}");

        return $this->httpClient->request('GET', $this->uri($sku), $options);
    }

    private function uri(string $sku): string
    {
        return "{$sku}/json";
    }
}

