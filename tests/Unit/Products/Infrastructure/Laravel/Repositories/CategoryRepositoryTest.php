<?php

namespace Src\Products\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private CategoryRepository $repository;
    private User $user;
    private mixed $result;

    public function test_should_get_category(): void
    {
        // Arrange
        $user = UserData::make();
        CategoryData::travel($user);
        $repository = new CategoryRepository();

        // Act
        $result = $repository->get('1', $user->getId());

        // Assert
        $this->assertInstanceOf(Category::class, $result);
        $this->assertSame('1', $result->category_id);
    }

    public function test_should_not_get_category(): void
    {
        // Arrange
        $user = UserData::make();
        $repository = new CategoryRepository();

        // Act
        $result = $repository->get('1', $user->getId());

        // Assert
        $this->assertNull($result);
    }

    public function test_should_get_parent_category(): void
    {
        // Arrange
        $user = UserData::make();
        CategoryData::travel($user);
        CategoryData::babyCarriage($user);
        $repository = new CategoryRepository();

        // Act
        $result = $repository->getParent('10', $user->getId());

        // Assert
        $this->assertInstanceOf(Category::class, $result);
        $this->assertSame('1', $result->category_id);
    }

    public function test_should_insert_category(): void
    {
        // Arrange
        $user = UserData::make();
        $repository = new CategoryRepository();
        $category = new Category([
            'name' => 'Carrinhos de Bebê',
            'category_id' => '10',
            'parent_category_id' => '1',
        ]);

        // Act
        $result = $repository->insert($category, $user->getId());

        // Assert
        $categoryCount = Category::fromUser((int) $user->id)->count();
        $this->assertSame(1, $categoryCount);
        $this->assertTrue($result);
    }

    public function test_should_list_categories(): void
    {
        // Arrange
        $user = UserData::make();
        CategoryData::travel($user);
        CategoryData::babyCarriage($user);
        $repository = new CategoryRepository();

        // Act
        $result = $repository->list($user->getId());

        // Assert
        $this->assertSame(2, count($result));
        $this->assertContainsOnlyInstancesOf(Category::class, $result);
    }

    public function test_should_check_if_category_already_exists(): void
    {
        // Arrange
        $user = UserData::make();
        CategoryData::travel($user);
        $repository = new CategoryRepository();

        // Act
        $result = $repository->exists('1', $user->getId());

        // Assert
        $this->assertTrue($result);
    }

    public function test_should_count_categories(): void
    {
        // Arrange
        $user = UserData::make();
        CategoryData::travel($user);
        CategoryData::babyCarriage($user);
        $repository = new CategoryRepository();

        // Act
        $result = $repository->count($user->getId());

        // Assert
        $this->assertSame(2, $result);
    }

    public function test_should_get_last_updated_datetime(): void
    {
        // Arrange
        $user = UserData::make();
        CategoryData::travel($user);
        CategoryData::babyCarriage($user);
        $repository = new CategoryRepository();

        // Act
        $result = $repository->getLastUpdatedAt($user->getId());

        // Assert
        $this->assertInstanceOf(Carbon::class, $result);
    }
}
