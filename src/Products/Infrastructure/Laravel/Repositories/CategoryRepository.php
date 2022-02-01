<?php

namespace Src\Products\Infrastructure\Laravel\Repositories;

use Src\Products\Domain\Models\Categories\Category;
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

    public function insert(Category $category): bool
    {
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
}