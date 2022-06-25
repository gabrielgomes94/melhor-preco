<?php

namespace Src\Products\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Domain\Repositories\Contracts\CategoryRepository as CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function get(string $categoryId): ?Category
    {
        return Category::where('category_id', $categoryId)->first();
    }

    public function getParent(string $categoryId)
    {
        return Category::first('category_id', $categoryId)->parent();
    }

    public function insert(Category $category, string $userId): bool
    {
        $category->user_id = $userId;

        return $category->save();
    }

    public function list()
    {
        return Category::all();
    }

    public function exists(string $categoryId): bool
    {
        return (bool) Category::where('category_id', $categoryId)->first();
    }

    public function count(): int
    {
        $userId = auth()->user()->id;

        return Category::where('user_id', $userId)->count();
    }

    public function getLastUpdatedAt(): ?Carbon
    {
        $userId = auth()->user()->id;

        return Category::where('user_id', $userId)
            ->orderByDesc('updated_at')
            ->first()
            ?->updated_at;
    }
}
