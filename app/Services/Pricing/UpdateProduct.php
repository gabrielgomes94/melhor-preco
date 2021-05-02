<?php

namespace App\Services\Pricing;
use App\Repositories\Pricing\UpdateRepository;

class UpdateProduct
{
    private UpdateRepository $repository;

    public function __construct(UpdateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function updateProduct(string $productId, array $data): bool
    {
        return $this->repository->update($productId, $data);
    }
}
