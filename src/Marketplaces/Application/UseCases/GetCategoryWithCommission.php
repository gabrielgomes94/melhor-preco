<?php

namespace Src\Marketplaces\Application\UseCases;

use Src\Products\Domain\Models\Categories\Category;
use Src\Products\Domain\Repositories\Contracts\CategoryRepository;

class GetCategoryWithCommission
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(): array
    {
        $categories = $this->repository->list();

        return $categories->map(function(Category $category) {
            return [
                'name' => $category->getFullName(),
                'categoryId' => $category->getCategoryId(),
                'parentId' => $category->getParentId()
            ];
        })->sortBy('name')->toArray();
    }
}
