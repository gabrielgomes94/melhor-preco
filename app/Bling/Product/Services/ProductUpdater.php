<?php
namespace App\Bling\Product\Services;

use App\Bling\Product\Client;
use App\Barrigudinha\Product\Product;
use SimpleXMLElement;

class ProductUpdater
{
    /**
     * @var Client
     */
    private $blingClient;

    public function __construct(Client $blingClient)
    {
        $this->blingClient = $blingClient;
    }

    public function update(Product $product)
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><xml/>');

        $productXML = $xml->addChild('produto');
        $productXML->addChild('codigo', $product->getSku());
        $productXML->addChild('descricao', $product->getName());
        $productXML->addChild('marca', $product->getBrand());
        $images = $productXML->addChild('imagens');

        foreach($product->getImages() as $imageUrl)  {
            $images->addChild('url', $imageUrl);
        }

        $data = $this->blingClient->post($product->getSku(), $xml->asXML());

        return $data;
    }
}
