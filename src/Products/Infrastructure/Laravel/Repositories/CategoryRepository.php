<?php

namespace Src\Products\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Domain\Repositories\CategoryRepository as CategoryRepositoryInterface;
use Src\Users\Domain\Exceptions\UserNotAuthenticated;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function exists(string $categoryId, string $userId): bool
    {
        return (bool) $this->get($categoryId, $userId);
    }

    public function get(string $categoryId, string $userId): ?Category
    {
        return Category::fromUser((int) $userId)
            ->withId($categoryId)
            ->first();
    }

    public function getParent(string $categoryId, string $userId): ?Category
    {
        $category = $this->get($categoryId, $userId);

        return $category->parent;
    }

    public function insert(Category $category, string $userId): bool
    {
        $category->user_id = $userId;
        $category->uuid = Uuid::uuid4();

        return $category->save();
    }

    public function list(string $userId)
    {
        return Category::fromUser($userId)->get()->all();
    }

    public function count(string $userId): int
    {
        return Category::fromUser($userId)->count();
    }

    public function getLastUpdatedAt(string $userId): ?Carbon
    {
        return Category::fromUser($userId)
            ->orderByDesc('updated_at')
            ->first()
            ?->updated_at;
    }
}
