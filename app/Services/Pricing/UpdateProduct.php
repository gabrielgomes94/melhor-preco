<?php

namespace App\Services\Pricing;
use App\Repositories\Pricing\UpdateProductRepository;

class UpdateProduct
{
    private UpdateProductRepository $repository;

    public function __construct(UpdateProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function updateProduct(string $productId, array $data): bool
    {
        return $this->repository->update($productId, $data);
    }
}
