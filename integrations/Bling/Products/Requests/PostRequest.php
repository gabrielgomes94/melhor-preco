<?php

namespace Integrations\Bling\Products\Requests;

use GuzzleHttp\Client as GuzzleClient;
use Integrations\Bling\Base\Request;
use Psr\Http\Message\ResponseInterface;

class PostRequest extends Request
{
    public function __construct(GuzzleClient $httpClient, array $options = [])
    {
        $options = array_replace($options, [
            'base_uri' => 'https://bling.com.br/Api/v2/produto/',
        ]);

        parent::__construct($httpClient, $options);
    }

    public function post(string $sku, string $xml): ResponseInterface
    {
        $this->options['query']['xml'] = $xml;
        $this->options['headers']['Content-Type'] = 'text/xml';

        return $this->httpClient->request('POST', "{$sku}/json", $this->options);
    }
}
