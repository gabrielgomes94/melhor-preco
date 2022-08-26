<?php

namespace Tests\Feature\Costs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\Feature\Users\Concerns\UsersDatabase;
use Tests\FeatureTestCase;
use Tests\TestCase;

class ListProductsCostsTest extends FeatureTestCase
{
    use RefreshDatabase;
    use UsersDatabase;

    public function test_shoud_list_products_costs(): void
    {
        $this->given_i_am_a_logged_user();
        $this->given_i_have_some_products_persisted();

        $this->when_i_want_to_list_those_product_costs();

        $this->then_it_must_render_products_costs_list();
        $this->then_the_list_must_contains_all_products();
    }

    public function test_should_list_products_costs_when_filtering_by_sku(): void
    {
        $this->given_i_am_a_logged_user();
        $this->given_i_have_some_products_persisted();

        $this->when_i_want_to_filter_products_on_list_by_sku();

        $this->then_it_must_render_products_costs_list();
        $this->then_the_list_must_contains_only_the_filtered_products();
    }

    private function given_i_have_some_products_persisted(): void
    {
        ProductData::babyCarriage($this->user);
        ProductData::babyChair($this->user);
        ProductData::babyPacifier($this->user);
    }

    private function then_it_must_render_products_costs_list(): void
    {
        $this->response->assertStatus(200);
        $this->response->assertViewIs('pages.costs.products.list');
        $this->response->assertViewHas('paginator');
    }

    private function then_the_list_must_contains_all_products()
    {
        $products = $this->response->viewData('products');

        $this->assertContainsOnlyInstancesOf(Product::class, $products);
        $this->assertCount(2, $products);
        $this->response->assertViewHas('filter', ['sku' => null]);
    }

    private function then_the_list_must_contains_only_the_filtered_products()
    {
        $products = $this->response->viewData('products');

        $this->assertContainsOnlyInstancesOf(Product::class, $products);
        $this->assertCount(1, $products);
        $this->response->assertViewHas('filter', ['sku' => '1234']);
    }

    private function when_i_want_to_list_those_product_costs(): void
    {
        $this->response = $this
            ->actingAs($this->user)
            ->get('/custos/produtos/lista');
    }

    private function when_i_want_to_filter_products_on_list_by_sku(): void
    {
        $this->response = $this
            ->actingAs($this->user)
            ->get('/custos/produtos/lista?sku=1234');
    }
}
