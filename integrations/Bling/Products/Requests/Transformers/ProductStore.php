<?php

namespace Integrations\Bling\Products\Requests\Transformers;

use SimpleXMLElement;

class ProductStore
{
    public static function generateXML(string $productStoreSku, string $priceValue): string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><produtosLoja/>');
        $productStore = $xml->addChild('produtoLoja');
        $productStore->addChild('idLojaVirtual', $productStoreSku);
        $price = $productStore->addChild('preco');
        $price->addChild('preco', $priceValue);
        $price->addChild('precoPromocional', $priceValue);

        return  $xml->asXML();
    }
}