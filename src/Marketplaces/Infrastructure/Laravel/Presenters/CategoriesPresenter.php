<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Presenters;

use Src\Marketplaces\Infrastructure\Laravel\Models\Commission\CategoryCommission;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Domain\Repositories\CategoryRepository;

class CategoriesPresenter
{
    public function __construct(
        private readonly CategoryRepository $repository,
    ) {}

    public function presentWithCommission(Marketplace $marketplace, string $userId): array
    {
        $categories = $this->repository->list($userId);
        $categories = collect($categories);

        if (!$marketplace->getCommission() instanceof CategoryCommission) {
            return [];
        }

        $commission = $marketplace->getCommission();

        return $categories->map(function (Category $category) use ($commission) {
            $categoryId = $category->getCategoryId();
            $commission = $commission->get($categoryId);

            return [
                'name' => $category->getFullName(),
                'categoryId' => $categoryId,
                'parentId' => $category->getParentId(),
                'commission' =>  $commission?->get(),
            ];
        })->sortBy('name')->toArray();
    }
}
