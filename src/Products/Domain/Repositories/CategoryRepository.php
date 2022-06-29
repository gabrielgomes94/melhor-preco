<?php

namespace Src\Products\Domain\Repositories;

use Carbon\Carbon;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;

interface CategoryRepository
{
    public function exists(string $categoryId, string $userId);

    public function get(string $categoryId, string $userId);

    public function getParent(string $categoryId, string $userId);

    public function insert(Category $category, string $userId);

    public function list(string $userId);

    public function count(string $userId): int;

    public function getLastUpdatedAt(string $userId): ?Carbon;
}
