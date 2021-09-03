<?php

namespace App\Services\Product\Images;

use App\Repositories\Product\GetDB;
use Barrigudinha\Product\Entities\Product;
use Illuminate\Support\Facades\Storage;
use Integrations\Bling\Products\Clients\ProductStore;
use Integrations\Bling\Products\Responses\Factories\ErrorResponse;
use Integrations\Bling\Products\Responses\Product as ProductResponse;
use SimpleXMLElement;

class StoreImages
{
    private GetDB $finder;
    private ProductStore $client;

    public function __construct(GetDB $finder, ProductStore $client)
    {
        $this->finder = $finder;
        $this->client = $client;
    }

    public function execute(string $sku, array $images): bool
    {
        $response = $this->client->get($sku);

        if (!$response instanceof ProductResponse) {
            throw new \Exception('Produto não encontrado');
        }

        $data = $response->data()->toArray();
        $path = $this->getPath($data['sku'], $data['name'], $data['brand']);
        $urls = $this->storeImages($path, $images);

        $updateResponse = $this->client->update($data['sku'], $this->getXML($urls));

        if ($updateResponse instanceof ErrorResponse) {
            throw new \Exception("Erro: produto não foi enviado para o Bling");
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
