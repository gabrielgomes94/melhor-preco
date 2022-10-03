<?php

namespace Src\Products\Infrastructure\Laravel\Models\Categories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_instantiate_category(): void
    {
        // Arrange
        $user = UserData::persisted();

        // Act
        $instance = CategoryData::babyCarriage($user);

        // Assert
        $this->assertSame('10', $instance->getCategoryId());
        $this->assertSame('Carrinhos de Bebê', $instance->getFullName());
        $this->assertSame('Carrinhos de Bebê', $instance->getName());
        $this->assertSame('', $instance->getParentId());
        $this->assertSame(0, $instance->getDepthLevelCategoryTree());
    }

    public function test_should_get_categories_from_user(): void
    {
        // Arrange
        $user = UserData::persisted();
        CategoryData::babyCarriage($user);
        CategoryData::babyChair($user);

        // Act
        $result = Category::fromUser($user->getId());

        // Assert
        $this->assertCount(2, $result->get());
    }

    public function test_should_get_categories_with_id(): void
    {
        // Arrange
        $user = UserData::persisted();
        CategoryData::babyCarriage($user);
        CategoryData::babyChair($user);

        // Act
        $result = Category::withId('10');

        // Assert
        $this->assertCount(1, $result->get());
    }
}
