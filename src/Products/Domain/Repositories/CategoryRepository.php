<?php

namespace Src\Products\Domain\Repositories;

use Carbon\Carbon;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;

interface CategoryRepository
{
    public function exists(string $categoryId);

    public function get(string $categoryId);

    public function getParent(string $categoryId);

    public function insert(Category $category);

    public function list();

    public function count(): int;

    public function getLastUpdatedAt(): ?Carbon;
}
