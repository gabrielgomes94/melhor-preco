<?php

namespace Src\Products\Application\UseCases;

use Src\Products\Domain\Repositories\Contracts\Erp\ProductRepository;
use Src\Products\Domain\UseCases\Contracts\UploadImages as UploadImagesInterface;

class UploadImages implements UploadImagesInterface
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(string $sku, string $name, string $brand, array $images): bool
    {
        $path = $this->getPath($sku, $name, $brand);
        $this->productRepository->uploadImages($sku, $path, $images);

        return true;
    }

    private function getPath(string $sku, string $name, string $brand): string
    {
        $name = preg_replace('/\//', '', $name);

        return "{$brand}/{$sku} - {$name}";
    }
}
