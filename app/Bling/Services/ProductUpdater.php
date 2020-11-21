<?php
namespace App\Bling\Services;

use App\Bling\Data\Product;

class ProductUpdater
{
    public function update(Product $product)
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><xml/>');

        $product = $xml->addChild('produto');
        $product->addChild('codigo', $product->getCode());
        $product->addChild('descricao', $product->getName());
        $product->addChild('marca', $product->getBrand());
        $images = $product->addChild('imagens');

        foreach($product->getImages() as $imageUrl)  {
            $images->addChild('url', $imageUrl);
        }

        $data = $this->blingClient->post($product->getCode(), $xml->asXML());

        return $data;
    }


}
