<?php

namespace Src\Products\Infrastructure\Laravel\Services;

use Src\Products\Domain\DataTransfer\ProductImages;
use Src\Products\Domain\Repositories\Erp\ProductRepository;
use Src\Products\Domain\Services\UploadImages as UploadImagesInterface;
use Src\Users\Domain\Models\User;

class UploadImages implements UploadImagesInterface
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(ProductImages $productImages, User $user): bool
    {
        return $this->productRepository->uploadImages(
            $user->getErpToken(),
            $productImages->sku,
            $this->getPath($user, $productImages->sku, $productImages->name),
            $productImages->images
        );
    }

    private function getPath(User $user, string $sku, string $name): string
    {
        $basePath = hash('sha256', $user->getName() . $user->getFiscalId());

        return "$basePath/{$sku} - {$name}";
    }
}
