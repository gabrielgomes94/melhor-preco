<?php

namespace Integrations\Bling\Products\Requests;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

class ListRequest
{
    protected GuzzleClient $httpClient;
    protected array $options;

    public function __construct(GuzzleClient $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->options = [
            'base_uri' => 'https://Bling.com.br/Api/v2/produtos/',
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
    public function all(int $page = 1): ResponseInterface
    {
        return $this->httpClient->request('GET', $this->uriPaginated($page), $this->options);
    }

    private function uriPaginated(int $page): string
    {
        return "page={$page}/json/";
    }
}
