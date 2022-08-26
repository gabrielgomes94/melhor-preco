<?php

namespace Tests\Feature\Costs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class UpdateProductCostsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private TestResponse $response;

    public function test_should_update_product_costs(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_a_product();

        $this->when_i_update_its_costs();

        $this->then_the_user_is_redirected();
        $this->and_then_the_product_costs_are_updated_in_database();
    }

    public function test_should_not_update_when_there_is_validation_errors(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_a_product();

        $this->when_i_update_its_costs_with_invalid_values();

        $this->then_the_user_is_redirected_with_errors();
        $this->and_then_the_product_costs_are_not_updated_in_database();
    }

    public function test_should_handle_errors_when_product_does_not_exists(): void
    {
        $this->given_i_have_an_user();

        $this->when_i_update_the_costs_of_a_missing_product();

        $this->then_the_user_is_redirected_with_missing_product_errors();
    }

    private function given_i_have_an_user(): void
    {
        $this->user = UserData::make();
    }

    private function and_given_i_have_a_product(): void
    {
        ProductData::babyCarriage($this->user);
    }

    private function when_i_update_its_costs(): void
    {
        $this->response = $this
            ->actingAs($this->user)
            ->put('/custos/produtos/atualizar/1234', [
                'purchasePrice' => 60,
                'taxICMS' => 10,
                'additionalCosts' => 5,
            ]);
    }

    private function when_i_update_its_costs_with_invalid_values(): void
    {
        $this->response = $this
            ->actingAs($this->user)
            ->put('/custos/produtos/atualizar/1', [
                'purchasePrice' => 'sixty',
                'taxICMS' => false,
                'additionalCosts' => 'zero',
            ]);
    }

    private function when_i_update_the_costs_of_a_missing_product(): void
    {
        $this->when_i_update_its_costs();
    }

    private function then_the_user_is_redirected(): void
    {
        $this->response->assertRedirect();
        $this->response->assertSessionHas('message', 'Produto 1234 teve seu custo atualizado com sucesso.');

    }

    private function then_the_user_is_redirected_with_errors(): void
    {
        $this->response->assertRedirect();
        $this->response->assertSessionHasErrors([
            'purchasePrice' => 'O campo purchase price deve ser um número.',
            'taxICMS' => 'O campo tax i c m s deve ser um número.',
            'additionalCosts' => 'O campo additional costs deve ser um número.',
        ]);
    }

    private function then_the_user_is_redirected_with_missing_product_errors(): void
    {
        $this->response->assertRedirect();
        $this->response->assertSessionHas('error', 'Produto 1234 não foi encontrado.');
    }

    private function and_then_the_product_costs_are_updated_in_database(): void
    {
        $product = Product::where('sku', '1234')->get()->first();

        $this->assertSame(60.0, $product->getCosts()->purchasePrice());
        $this->assertSame(5.0, $product->getCosts()->additionalCosts());
        $this->assertSame(10.0, $product->getCosts()->taxICMS());
    }

    private function and_then_the_product_costs_are_not_updated_in_database(): void
    {
        $product = Product::where('sku', '1234')->get()->first();

        $this->assertSame(449.9, $product->getCosts()->purchasePrice());
        $this->assertSame(0.0, $product->getCosts()->additionalCosts());
        $this->assertSame(12.0, $product->getCosts()->taxICMS());
    }
}
