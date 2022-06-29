<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Services;

use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Domain\Repositories\CategoryRepository;

class GetCategoryWithCommission
{
    private CategoryRepository $repository;
    private MarketplaceRepository $marketplaceRepository;

    public function __construct(
        CategoryRepository $repository,
        MarketplaceRepository $marketplaceRepository
    ) {
        $this->repository = $repository;
        $this->marketplaceRepository = $marketplaceRepository;
    }

    public function get(string $marketplaceSlug, string $userId): array
    {
        $marketplace = $this->marketplaceRepository->getBySlug($marketplaceSlug);
        $categories = $this->repository->list($userId);

        return $categories->map(function (Category $category) use ($marketplace) {
            $categoryId = $category->getCategoryId();
            $commission = $marketplace->getCommissionByCategory($categoryId);

            return [
                'name' => $category->getFullName(),
                'categoryId' => $categoryId,
                'parentId' => $category->getParentId(),
                'commission' =>  $commission?->get(),
            ];
        })->sortBy('name')->toArray();
    }
}
