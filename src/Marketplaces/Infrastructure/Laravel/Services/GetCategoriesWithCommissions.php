<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Services;

use Src\Marketplaces\Domain\Services\GetCategoriesWithCommissions as GetCategoriesWithCommissionsInterface;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Domain\Repositories\CategoryRepository;

class GetCategoriesWithCommissions implements GetCategoriesWithCommissionsInterface
{
    public function __construct(
        private readonly CategoryRepository $repository,
    ) {}

    public function get(Marketplace $marketplace, string $userId): array
    {
        $categories = $this->repository->list($userId);
        $categories = collect($categories);

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
