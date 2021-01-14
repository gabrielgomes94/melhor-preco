<?php
namespace App\Bling;

use App\Bling\Response\Factory;
use App\Bling\Response\ProductResponse;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

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

    private $responseFactory;

    public function __construct(Factory $responseFactory)
    {
        $this->responseFactory = $responseFactory;

        $this->guzzleClient = new GuzzleClient([
            'base_uri' => 'https://bling.com.br/Api/v2/produto/',
        ]);

        $this->options = [
            'query' => [
                'apikey' => env('BLING_API_KEY'),
                'imagem' => 'S',
            ],
        ];
    }

    public function get(string $sku): array
    {
        try {
            $response = $this->guzzleClient->request('GET', "{$sku}/json", $this->options);
            $data = json_decode((string) $response->getBody(), true);
        } catch(GuzzleException $exception) {
            $data = [
                'errors' => 'ERRO: ou a conexão de internet está muito instável ou a API do Bling está fora do ar. Tente novamente mais tarde.',
            ];
        } catch(\Exception $exception) {
            $data = [
                'errors' => 'Aconteceu algum erro bizarro. Contate o suporte.',
            ];
        }

        return $data;
    }

    public function getWithStock(string $sku)
    {
        $this->options['query']['estoque'] = 'S';

        try {
            $response = $this->guzzleClient->request('GET', "{$sku}/json", $this->options);
            $data = json_decode((string) $response->getBody(), true);

            $productResponse = new ProductResponse($response);
        } catch(GuzzleException $exception) {
            $data = [
                'errors' => 'ERRO: ou a conexão de internet está muito instável ou a API do Bling está fora do ar. Tente novamente mais tarde.',
            ];
        } catch(\Exception $exception) {
            $data = [
                'errors' => 'Aconteceu algum erro bizarro. Contate o suporte.',
            ];
        }

//        return $data;
    }

    public function post(string $sku, string $xml)
    {
        $this->options['query']['xml'] = $xml;
        $this->options['headers']['Content-Type'] = 'text/xml';

        $response = $this->guzzleClient->request('POST', "{$sku}/json", $this->options);
        $data = json_decode((string) $response->getBody(), true);

        return $data;
    }
}
