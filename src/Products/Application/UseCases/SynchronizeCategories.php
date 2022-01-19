<?php

namespace Src\Products\Application\UseCases;

use Src\Products\Domain\Repositories\Contracts\CategoryRepository;
use Src\Products\Domain\Repositories\Contracts\Erp\CategoryRepository;
use Src\Products\Domain\UseCases\Contracts\SyncCategories;

class SynchronizeCategories implements SyncCategories
{
    private CategoryRepository $categoryRepository;
    private CategoryRepository $erpCategoryRepository;

    public function __construct(CategoryRepository $categoryRepository, CategoryRepository $erpCategoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->erpCategoryRepository = $erpCategoryRepository;
    }

    public function sync(): void
    {
        $data = $this->erpCategoryRepository->list();

        foreach ($data as $category) {
            if ($this->categoryRepository->exists($category->getCategoryId())) {
                continue;
            }

            $this->categoryRepository->insert($category);
        }
    }
}
