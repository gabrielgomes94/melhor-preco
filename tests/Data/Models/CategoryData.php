<?php

namespace Tests\Data\Models;

use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Users\Infrastructure\Laravel\Models\User;

class CategoryData
{
    public static function persisted(string $method, User $user, array $data = []): Category
    {
        $category = new Category(
            array_merge(self::$method(), $data)
        );

        $category->user_id = $user->getId();
        $category->save();

        return $category;
    }

    public static function withoutParent(): array
    {
        return [
            'category_id' => '1',
            'parent_category_id' => '0',
            'name' => 'Carrinhos',
        ];
    }

    public static function withParent(): array
    {
        return [
            'category_id' => '10',
            'parent_category_id' => '1',
            'name' => 'Carrinhos de supermercado',
        ];
    }
}
