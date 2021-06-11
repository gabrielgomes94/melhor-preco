<?php

namespace Integrations\Bling\Products\Requests;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ListRequest extends BaseRequest
{
    public function __construct(Client $httpClient, array $options = [])
    {
        parent::__construct($httpClient, $options);
        $options = [
            'base_uri' => 'https://Bling.com.br/Api/v2/produtos/',
            'query' => [
                'apikey' => env('BLING_API_KEY'),
                'estoque' => 'S',
                'imagem' => 'S',
            ],
        ];

        $this->options = $options;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all(int $page = 1, string $store = ''): ResponseInterface
    {
        $this->options['query']['loja'] = config('stores_code.' . $store) ?? null;

        $response = $this->httpClient->request(
            'GET',
            $this->uriPaginated($page),
            $this->options
        );

        return $response;
    }

    private function uriPaginated(int $page): string
    {
        return "page={$page}/json/";
    }
}
