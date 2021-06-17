<?php

namespace Integrations\Bling\Products\Requests;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

class PutRequest extends BaseRequest
{
    public function __construct(GuzzleClient $httpClient, array $options = [])
    {
        $options = array_replace($options, [
            'base_uri' => 'https://bling.com.br/Api/v2/produtoLoja/',
        ]);

        parent::__construct($httpClient, $options);
    }

    public function put(string $sku, string $storeCode, string $xml): ResponseInterface
    {
        $this->options['query']['xml'] = $xml;
        $this->options['headers']['Content-Type'] = 'text/xml';

        return $this->httpClient->request('PUT', "{$storeCode}/{$sku}/json", $this->options);
    }
}
