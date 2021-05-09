<?php

namespace Integrations\Bling\Products\Requests;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ListRequest extends BaseRequest
{
    public function __construct(Client $httpClient, array $options = [])
    {
        $options = array_replace($options, [
            'base_uri' => 'https://Bling.com.br/Api/v2/produtos/',
        ]);

        parent::__construct($httpClient, $options);
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
