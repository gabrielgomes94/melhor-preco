<?php

namespace Src\Products\Domain\Repositories\Contracts;

use Src\Products\Domain\Models\Categories\Category;

interface CategoryRepository
{
    public function exists(string $categoryId);

    public function get(string $categoryId);

    public function getParent(string $categoryId);

    public function insert(Category $category);

    public function list();
}
