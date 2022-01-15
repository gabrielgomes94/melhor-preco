<?php

namespace Src\Products\Application\UseCases;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;
use Src\Integrations\Bling\Base\Responses\ErrorResponse;
use Src\Integrations\Bling\Products\Client;
use Src\Products\Domain\UseCases\Contracts\UploadImages as UploadImagesInterface;
use Src\Products\Infrastructure\Bling\Responses\Product\Factory;

class UploadImages implements UploadImagesInterface
{
    private Client $client;
    private Factory $factory;

    public function __construct(Client $client, Factory $factory)
    {
        $this->client = $client;
        $this->factory = $factory;
    }

    public function execute(string $sku, string $name, string $brand, array $images): bool
    {
        $path = $this->getPath($sku, $name, $brand);
        $urls = $this->storeImages($path, $images);

        $updateResponse = $this->client->update($sku, $this->getXML($urls));
        $updateResponse = $this->factory->make($updateResponse);

        if ($updateResponse instanceof ErrorResponse) {
            Log::error(
                'Produto: Imagens não foram enviadas para o Bling',
                $updateResponse->errors()
            );

            throw new \Exception("Erro: produto não foi enviado para o Bling.");
        }

        return true;
    }

    private function getPath(string $sku, string $name, string $brand): string
    {
        $name = preg_replace('/\//', '', $name);

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
