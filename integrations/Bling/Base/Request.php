<?php

namespace Integrations\Bling\Base;

use GuzzleHttp\Client as GuzzleClient;

class Request
{
    protected GuzzleClient $httpClient;
    protected array $options;

    public function __construct(GuzzleClient $httpClient, array $options)
    {
        $this->options = [
            'base_uri' => $options['base_uri'] ?? '',
            'query' => [
                'apikey' => env('BLING_API_KEY'),
                'estoque' => 'S',
                'imagem' => 'S',
            ],
        ];

        $this->httpClient = $httpClient;
    }
}