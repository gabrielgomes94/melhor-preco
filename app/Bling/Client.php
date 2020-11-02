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
                'apikey' => env('BLING_API_KEY'),
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
                'apikey' => env('BLING_API_KEY'),
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
