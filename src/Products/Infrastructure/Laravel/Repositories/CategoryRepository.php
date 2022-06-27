<?php

namespace Src\Products\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Domain\Repositories\CategoryRepository as CategoryRepositoryInterface;
use Src\Users\Domain\Exceptions\UserNotAuthenticated;

class CategoryRepository implements CategoryRepositoryInterface
{
    private string $userId;

    public function __construct()
    {
        if (!$user = auth()->user()) {
            throw new UserNotAuthenticated();
        }

        $this->userId = $user->getAuthIdentifier();
    }

    public function exists(string $categoryId): bool
    {
        return (bool) $this->get($categoryId);
    }

    public function get(string $categoryId): ?Category
    {
        return Category::fromUser((int) $this->userId)
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
        return Category::fromUser($this->userId)->get()->all();
    }

    public function count(): int
    {
        return Category::fromUser($this->userId)->count();
    }

    public function getLastUpdatedAt(): ?Carbon
    {
        return Category::fromUser($this->userId)
            ->orderByDesc('updated_at')
            ->first()
            ?->updated_at;
    }
}
