<?php
namespace App\Bling;

use SimpleXMLElement;

class ProductService
{
    /**
     * @var Client
     */
    private $blingClient;

    public function __construct(Client $blingClient)
    {
        $this->blingClient = $blingClient;
    }

    public function uploadImages(array $data, $urls)
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><xml/>');
        $product = $xml->addChild('produto');
        $product->addChild('codigo', $data['codigo']);
        $product->addChild('descricao', $data['descricao']);
        $product->addChild('descricaoCurta', $data['descricaoCurta']);
        $images = $product->addChild('imagens');


        foreach($urls as $url)  {
            $images->addChild('url', $url);
        }

//        dd($xml->asXML());
        $data = $this->blingClient->post($data['codigo'], $xml->asXML());
        return $data;
    }
}
