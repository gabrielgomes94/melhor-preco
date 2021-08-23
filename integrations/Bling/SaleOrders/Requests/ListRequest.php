<?php

namespace Integrations\Bling\SaleOrders\Requests;

use GuzzleHttp\Client as GuzzleClient;
use Integrations\Bling\Base\Request;

class ListRequest extends Request
{
    private const API_ENDPOINT = 'https://bling.com.br/Api/v2/pedidos/json/';

    public function __construct(GuzzleClient $httpClient, array $options = [])
    {
        $options = array_replace($options, [
            'base_uri' => self::API_ENDPOINT,
        ]);

        parent::__construct($httpClient, $options);


    }

    public function all()
    {
        $response = $this->httpClient->request(
            'GET', '',
//            $this->uriPaginated($page),
            $this->options
        );
//dd('adsdasd');
//        dd($response);

        return $response;
    }

}
