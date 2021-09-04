<?php

namespace App\Services\Product\Images;

use App\Repositories\Product\GetDB;
use Illuminate\Support\Facades\Storage;
use Integrations\Bling\Products\Clients\ProductStore;
use Integrations\Bling\Products\Responses\Error as ErrorResponse;
use SimpleXMLElement;

class StoreImages
{
    private ProductStore $client;

    public function __construct(ProductStore $client)
    {
        $this->client = $client;
    }

    public function execute(string $sku, string $name, string $brand, array $images): bool
    {
        $path = $this->getPath($sku, $name, $brand);
        $urls = $this->storeImages($path, $images);

        $updateResponse = $this->client->update($sku, $this->getXML($urls));

        if ($updateResponse instanceof ErrorResponse) {
            throw new \Exception("Erro: produto não foi enviado para o Bling.");
        }

        return true;
    }

    private function getPath(string $sku, string $name, string $brand): string
    {
        $name = preg_replace('/\//', '',  $name);

        return "{$brand}/{$sku} - {$name}";
    }

    private function storeImages(string $path, array $images): array
    {
        foreach ($images as $image) {
            $url = Storage::putFileAs($path, $image, $image->getClientOriginalName(), 'public');
            $urls[] = Storage::url(urlencode($url));
        }

        return $urls ?? [];
    }

    private function getXML(array $urls): string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><xml/>');

        $productXML = $xml->addChild('produto');
        $images = $productXML->addChild('imagens');

        foreach ($urls as $url) {
            $images->addChild('url', $url);
        }

        return $xml->asXML();
    }
}
