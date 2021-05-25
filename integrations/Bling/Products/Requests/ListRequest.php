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
                'loja' => '203482706', // B2W apenas. TODO: permitir outras lojas futuramente
                'estoque' => 'S',
                'imagem' => 'S',
            ],
        ];

        $this->options = $options;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all(int $page = 1): ResponseInterface
    {
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
