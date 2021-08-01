<?php

namespace Integrations\Bling\Products\Requests;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

class GetRequest extends BaseRequest
{
    public function __construct(GuzzleClient $httpClient, array $options = [])
    {
        $options = array_replace($options, [
            'base_uri' => 'https://Bling.com.br/Api/v2/produto/',
        ]);

        parent::__construct($httpClient, $options);
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

