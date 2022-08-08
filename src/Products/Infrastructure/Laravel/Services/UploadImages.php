<?php

namespace Src\Products\Infrastructure\Laravel\Services;

use Src\Products\Domain\Repositories\Erp\ProductRepository;
use Src\Products\Domain\Services\UploadImages as UploadImagesInterface;

class UploadImages implements UploadImagesInterface
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @todo simplificar os parâmetros pra esse método
     * $user, $basePath, $images
     */
    public function execute(
        string $erpToken,
        string $sku,
        string $name,
        string $brand,
        array $images
    ): bool
    {
        $path = $this->getPath($sku, $name, $brand);
        $this->productRepository->uploadImages($erpToken, $sku, $path, $images);

        return true;
    }

    private function getPath(string $sku, string $name, string $brand): string
    {
        $name = preg_replace('/\//', '', $name);

        return "{$brand}/{$sku} - {$name}";
    }
}
