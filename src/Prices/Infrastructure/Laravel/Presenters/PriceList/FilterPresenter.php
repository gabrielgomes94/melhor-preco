<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\PriceList;

use Src\Products\Domain\Repositories\CategoryRepository;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;

class FilterPresenter
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository
    ) {
    }

    public function present(Options $options): array
    {
        $categories = $this->presentCategories($options->getUserId());

        return [
            'categories' => $categories,
            'minimumProfit' => $options->minimumProfit,
            'maximumProfit' => $options->maximumProfit,
            'sku' => $options->sku() ?? null,
        ];
    }

    private function presentCategories(string $userId): array
    {
        $categories = $this->categoryRepository->list($userId);

        $categories = collect($categories);
        $categories = $categories->map(
            fn (Category $category) => [
                'name' => $category->getFullName(),
                'category_id' => $category->getCategoryId(),
            ]
        );

        return $categories->sortBy('name')->toArray();
    }
}
