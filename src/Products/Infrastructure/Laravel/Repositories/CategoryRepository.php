<?php

namespace Src\Products\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Domain\Repositories\CategoryRepository as CategoryRepositoryInterface;
use Src\Users\Domain\Exceptions\UserNotAuthenticated;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function exists(string $categoryId): bool
    {
        return (bool) $this->get($categoryId);
    }

    public function get(string $categoryId): ?Category
    {
        $userId = $this->getUserIdentifier();
        return Category::fromUser((int) $userId)
            ->withId($categoryId)
            ->first();
    }

    public function getParent(string $categoryId): ?Category
    {
        $category = $this->get($categoryId);

        return $category->parent;
    }

    public function insert(Category $category): bool
    {
        $category->user_id = $this->userId;

        return $category->save();
    }

    public function list()
    {
        $userId = $this->getUserIdentifier();
        return Category::fromUser($userId)->get()->all();
    }

    public function count(): int
    {
        $userId = $this->getUserIdentifier();
        return Category::fromUser($userId)->count();
    }

    public function getLastUpdatedAt(): ?Carbon
    {
        $userId = $this->getUserIdentifier();
        return Category::fromUser($userId)
            ->orderByDesc('updated_at')
            ->first()
            ?->updated_at;
    }

    private function getUserIdentifier(): string
    {
        return auth()->user()->getAuthIdentifier();
    }
}
