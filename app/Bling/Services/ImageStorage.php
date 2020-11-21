<?php
namespace App\Bling\Services;

use App\Bling\Data\Product;
use Illuminate\Support\Facades\Storage;

class ImageStorage
{
    public function store(Product $product, array $files): array
    {
        $path = $this->getPath($product);

        $urls = [];
        foreach ($files as $file) {
            $url = Storage::putFileAs($path, $file, $file->getClientOriginalName(), 'public');

            $urls[] = Storage::url(urlencode($url));
        }

        return $urls;
    }

    private function getPath(Product $product)
    {
        $brand = $product->getBrand();
        $sku = $product->getCode();
        $name = preg_replace('/\//', '',  $product->getName());

        $path = "{$brand}/{$sku} - {$name}";

        return $path;
    }
}
