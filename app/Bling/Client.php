<?php
namespace App\Bling;

use GuzzleHttp\Client as GuzzleClient;

class Client
{
    /**
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     * @var array[]
     */
    private $options;

    public function __construct()
    {
        $this->guzzleClient = new GuzzleClient([
            'base_uri' => 'https://bling.com.br/Api/v2/produto/'
        ]);

        $this->options = [
            'query' => [
                'apikey' => 'd76ec48af93595cd2ce877f93289e4e3c0166705e07ae0206787853a145fd120a75a8c25',
                'imagem' => 'S',
            ],
        ];
    }

    public function get(string $sku)
    {
        $response = $this->guzzleClient->request('GET', "{$sku}/json", $this->options);

        $data = json_decode((string) $response->getBody(), true);

        return $data;
    }

    public function post(string $sku, string $xml)
    {
        $options = [
            'query' => [
                'apikey' => 'd76ec48af93595cd2ce877f93289e4e3c0166705e07ae0206787853a145fd120a75a8c25',
                'xml' => $xml,
                'imagem' => 'S',
            ],
            'headers' => [
                'Content-Type' => 'text/xml',
            ],
        ];

        $response = $this->guzzleClient->request('POST', "{$sku}/json", $options);
        $data = json_decode((string) $response->getBody(), true);

        return $data;
    }
}
