<?php

namespace Src\Products\Infrastructure\Laravel\Services;

use Src\Products\Domain\Repositories\CategoryRepository;
use Src\Products\Domain\Repositories\Erp\CategoryRepository as ErpCategoryRepository;
use Src\Products\Domain\Services\SyncCategories;
use Src\Users\Infrastructure\Laravel\Models\User;

class SynchronizeCategories implements SyncCategories
{
    private CategoryRepository $categoryRepository;
    private ErpCategoryRepository $erpCategoryRepository;

    public function __construct(CategoryRepository $categoryRepository, ErpCategoryRepository $erpCategoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->erpCategoryRepository = $erpCategoryRepository;
    }

    public function sync(User $user): void
    {
        $data = $this->erpCategoryRepository->list($user->getErpToken());

        foreach ($data as $category) {
            if ($this->categoryRepository->exists($category->getCategoryId(), $user->getId())) {
                continue;
            }

            $this->categoryRepository->insert($category, $user->getId());
        }
    }
}
