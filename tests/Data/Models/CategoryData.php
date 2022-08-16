<?php

namespace Tests\Data\Models;

use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Users\Infrastructure\Laravel\Models\User;

class CategoryData
{
    public static function persisted(User $user, array $data = [], string $method = 'withParent'): Category
    {
        $category = self::make($user, $data, $method);
        $category->save();

        return $category;
    }

    public static function make(User $user, array $data = [], string $method = 'withParent')
    {
        $category = new Category(
            array_merge(self::$method(), $data)
        );
        $category->user_id = $user->getId();

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

    public static function babyCarriage(User $user): Category
    {
        return self::persisted($user, [
            'name' => 'Carrinhos de Bebê',
            'category_id' => '10',
            'parent_category_id' => '1',
        ]);
    }

    public static function babyChair(User $user): Category
    {
        return self::persisted($user, [
            'name' => 'Cadeira de Bebê',
            'category_id' => '11',
            'parent_category_id' => '1',
        ]);
    }

    public static function travel(User $user)
    {
        return self::persisted($user, [
            'name' => 'Passeio do Bebê',
            'category_id' => '1',
            'parent_category_id' => '',
        ]);
    }
}
