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
        $images = $product->addChild('imagens');

        foreach($urls as $url)  {
            $images->addChild('url', $url);
        }

        $data = $this->blingClient->post($data['codigo'], $xml->asXML());
        return $data;
    }
}
