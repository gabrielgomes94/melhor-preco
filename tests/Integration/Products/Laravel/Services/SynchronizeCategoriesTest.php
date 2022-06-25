<?php

namespace Tests\Integration\Products\Laravel\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeCategories;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class SynchronizeCategoriesTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function test_should_sync_category(): void
    {
        $this->given_i_have_a_user_with_no_categories();
        $this->and_given_i_have_an_integration_with_bling_setup();

        $this->when_i_want_to_sync_categories();

        $this->then_i_must_have_in_database_the_categories_downloaded_from_bling();
    }

    private function given_i_have_a_user_with_no_categories(): void
    {
        $this->user = UserData::make();
    }

    private function and_given_i_have_an_integration_with_bling_setup(): void
    {
        $response = $this->getJsonFixture('Bling/Categories/list-categories.json');

        Http::fake([
            'bling.com.br/Api/v2/categorias/*' => Http::sequence()
                ->push($response)
                ->push([]),
        ]);
    }

    private function when_i_want_to_sync_categories(): void
    {
        $service = app(SynchronizeCategories::class);
        $service->sync($this->user);
    }

    private function then_i_must_have_in_database_the_categories_downloaded_from_bling(): void
    {
        $userId = $this->user->getId();
        $categoryCount = Category::where('user_id', $userId)->count();

        $this->assertSame(5, $categoryCount);
    }
}
