<?php

namespace Tests\Integration\Products\Laravel\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Products\Domain\UseCases\SyncProducts;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeProducts;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class SynchronizeProductsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function test_should_synchronize_new_products(): void
    {
        $this->given_i_have_an_user_with_no_products();
        $this->and_given_i_have_an_integration_with_bling_setup();

        $this->when_i_want_to_sync_products();

        $this->then_i_must_have_in_database_the_products_downloaded_from_bling();
    }

    public function test_should_synchronize_old_products(): void
    {
        $this->given_i_have_an_user_with_products();
        $this->and_given_i_have_an_integration_with_bling_setup();

        $this->when_i_want_to_sync_products();

        $this->then_i_must_have_in_database_the_products_updated_from_bling();
    }

    private function given_i_have_an_user_with_no_products(): void
    {
        $this->user = UserData::make();
    }

    private function and_given_i_have_an_integration_with_bling_setup(): void
    {
        $response = $this->getJsonFixture('Bling/Products/list-products.json');

        Http::fake([
            "bling.com.br/Api/v2/produtos/*" => Http::sequence()
                ->push($response)
                ->push([])
                ->push([]),
        ]);
    }

    private function when_i_want_to_sync_products(): void
    {
        $service = app(SynchronizeProducts::class);
        $service->sync($this->user);
    }

    private function then_i_must_have_in_database_the_products_downloaded_from_bling(): void
    {
        $userId = $this->user->getId();
        $productCount = Product::where('user_id', $userId)->count();

        $this->assertSame(2, $productCount);
    }

    private function given_i_have_an_user_with_products()
    {
        $this->user = UserData::make();

        ProductData::makePersisted($this->user, [
            'sku' => '1211',
            'name' => 'Carrinho Veneto',

        ]);
        ProductData::makePersisted($this->user, [
            'sku' => '344',
            'name' => 'Bebe Conforto',
        ]);
    }

    private function then_i_must_have_in_database_the_products_updated_from_bling()
    {
        $userId = $this->user->getId();
        $product_1 = Product::where('user_id', $userId)->where('sku', '1211')->first();
        $product_2 = Product::where('user_id', $userId)->where('sku', '344')->first();

        $this->assertSame('Carrinho Veneto Aviador Azul', $product_1->getName());
        $this->assertSame('Bebê Conforto Cocoon - Preto Cinza - Galzerano', $product_2->getName());
    }
}
