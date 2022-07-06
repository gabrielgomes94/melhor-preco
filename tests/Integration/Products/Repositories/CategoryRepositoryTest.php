<?php

namespace Tests\Integration\Products\Repositories;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Products\Domain\Repositories\CategoryRepository;
use Src\Products\Domain\Repositories\ProductRepository;
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
        $this->given_i_have_an_user();
        $this->given_i_have_a_category();

        $this->when_i_want_to_get_from_repository();

        $this->then_i_must_have_a_category_in_database();
    }

    public function test_should_not_get_category(): void
    {
        $this->given_i_have_an_user();

        $this->when_i_want_to_get_from_repository();

        $this->then_i_must_get_nothing();
    }

    public function test_should_get_parent_category(): void
    {
        $this->given_i_have_an_user();
        $this->given_i_have_a_category_with_parent();

        $this->when_i_want_to_get_parent_from_repository();

        $this->then_i_must_have_a_category_in_database();
    }

    public function test_should_insert_category(): void
    {
        $this->given_i_have_an_user();
        $this->when_i_want_to_insert_category();

        $this->then_i_must_have_a_category_inserted_in_database();
    }

    public function test_should_list_categories(): void
    {
        $this->given_i_have_an_user();
        $this->given_i_have_two_categories();

        $this->when_i_want_to_list_categories();

        $this->then_i_must_have_all_categories_in_list();
    }

    public function test_should_check_if_category_already_exists(): void
    {
        $this->given_i_have_an_user();
        $this->given_i_have_a_category();

        $this->when_i_want_to_check_if_category_exists();

        $this->then_the_result_must_be_true();
    }

    public function test_should_count_categories(): void
    {
        $this->given_i_have_an_user();
        $this->given_i_have_two_categories();

        $this->when_i_want_to_count_categories();

        $this->then_it_must_be_equals_to_two();
    }

    public function test_should_get_last_updated_datetime(): void
    {
        $this->given_i_have_an_user();
        $this->given_i_have_two_categories();

        $this->when_i_want_to_get_the_last_updated_datetime();

        $this->then_i_must_get_the_last_updated_datetime();
    }

    private function given_i_have_an_user(): void
    {
        $this->user = UserData::make();
        $this->actingAs($this->user);
    }

    private function given_i_have_a_category(): void
    {
        CategoryData::persisted($this->user, [], 'withoutParent');
    }

    private function given_i_have_a_category_with_parent(): void
    {
        CategoryData::persisted($this->user, [], 'withoutParent');
        CategoryData::persisted($this->user, []);
    }

    private function given_i_have_two_categories(): void
    {
        $this->given_i_have_a_category_with_parent();
    }

    private function then_i_must_get_nothing(): void
    {
        $this->assertNull($this->result);
    }

    private function then_i_must_have_a_category_in_database(): void
    {
        $this->assertInstanceOf(Category::class, $this->result);
        $this->assertSame('1', $this->result->category_id);
    }

    private function then_i_must_have_all_categories_in_list(): void
    {
        $this->assertSame(2, count($this->result));
        $this->assertContainsOnlyInstancesOf(Category::class, $this->result);
    }

    private function then_i_must_have_a_category_inserted_in_database(): void
    {
        $categoryCount = Category::fromUser((int) $this->user->id)->count();
        $this->assertSame(1, $categoryCount);
        $this->assertTrue($this->result);
    }

    private function then_the_result_must_be_true(): void
    {
        $this->assertTrue($this->result);
    }

    private function then_it_must_be_equals_to_two(): void
    {
        $this->assertSame(2, $this->result);
    }

    private function when_i_want_to_get_parent_from_repository(): void
    {
        $this->repository = $this->app->make(CategoryRepository::class);
        $this->result = $this->repository->getParent('10', $this->user->getId());
    }

    private function when_i_want_to_get_from_repository(): void
    {
        $this->repository = $this->app->make(CategoryRepository::class);
        $this->result = $this->repository->get('1', $this->user->getId());
    }

    private function when_i_want_to_insert_category(): void
    {
        $this->repository = $this->app->make(CategoryRepository::class);
        $category = new Category(CategoryData::withParent());
        $this->result = $this->repository->insert($category, $this->user->getId());
    }

    private function when_i_want_to_list_categories(): void
    {
        $this->repository = $this->app->make(CategoryRepository::class);
        $this->result = $this->repository->list($this->user->getId());
    }

    private function when_i_want_to_check_if_category_exists(): void
    {
        $this->repository = $this->app->make(CategoryRepository::class);
        $this->result = $this->repository->exists('1', $this->user->getId());
    }

    private function when_i_want_to_count_categories(): void
    {
        $this->repository = $this->app->make(CategoryRepository::class);
        $this->result = $this->repository->count($this->user->getId());
    }

    private function when_i_want_to_get_the_last_updated_datetime()
    {
        $this->repository = $this->app->make(CategoryRepository::class);
        $this->result = $this->repository->getLastUpdatedAt($this->user->getId());
    }

    private function then_i_must_get_the_last_updated_datetime()
    {
        $this->assertInstanceOf(Carbon::class, $this->result);
    }
}
