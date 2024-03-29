<?php

namespace Src\Prices\Infrastructure\Laravel\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Prices\Infrastructure\Laravel\Services\SynchronizeFromMarketplace;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class SynchronizeFromMarketplaceTest extends TestCase
{
    use RefreshDatabase;

    private Marketplace $marketplace;
    private User $user;

    public function test_should_insert_prices_from_a_marketplace(): void
    {
        $this->given_i_have_an_user_with_marketplace();
        $this->given_i_have_products_without_prices();
        $this->and_given_i_have_an_integration_with_bling_setup();

        $this->when_i_want_to_sync_prices();

        $this->then_the_prices_must_be_added_on_database();
    }

    public function test_should_update_prices_from_a_marketplace(): void
    {
        $this->given_i_have_an_user_with_marketplace();
        $this->and_given_i_have_the_prices_in_database();
        $this->and_given_i_have_an_integration_with_bling_setup();

        $this->when_i_want_to_sync_prices();

        $this->then_the_prices_must_be_updated_on_database();
    }

    public function test_should_handle_error_when_syncing(): void
    {
        $this->given_i_have_an_user_with_marketplace();
        $this->and_given_i_have_an_integration__with_errors_on_setup();

        $this->when_i_want_to_sync_prices();

        $this->then_database_must_be_remains_without_prices();
    }

    private function given_i_have_an_user_with_marketplace(): void
    {
        $this->user = UserData::persisted();
        $this->actingAs($this->user);

        $this->marketplace = MarketplaceData::magalu($this->user);
    }

    private function and_given_i_have_an_integration_with_bling_setup(): void
    {
        $response = $this->getJsonFixture('Bling/Products/list-products-store.json');
        Http::fake([
            'bling.com.br/Api/v2/produtos/*' => Http::sequence()
                ->push($response)
                ->push([]),
        ]);
    }

    private function when_i_want_to_sync_prices(): void
    {
        $service = $this->app->get(SynchronizeFromMarketplace::class);
        $service->sync($this->marketplace);
    }

    private function then_the_prices_must_be_added_on_database(): void
    {
        $pricesCount = Price::count();
        $this->assertSame(2, $pricesCount);
    }

    private function and_given_i_have_an_integration__with_errors_on_setup()
    {
        $response = $this->getJsonFixture('Bling/Errors/404.json');
        Http::fake([
            'bling.com.br/Api/v2/produtos/*' => Http::sequence()
                ->push($response),
        ]);
    }

    private function then_database_must_be_remains_without_prices()
    {
        $pricesCount = Price::count();
        $this->assertEmpty($pricesCount);
    }

    private function and_given_i_have_the_prices_in_database(): void
    {
        $marketplace = MarketplaceData::magalu($this->user);

        PriceData::persisted(
            ProductData::babyCarriage($this->user),
            $marketplace
        );

        PriceData::persisted(
            ProductData::babyChair($this->user),
            $marketplace
        );
    }

    private function then_the_prices_must_be_updated_on_database()
    {
        $price_1 = Price::where('product_uuid', 'fdb452fd-fc5f-4267-89dd-32e2010cb946')
            ->first();

        $this->assertSame('459.90', $price_1->value);

        $price_2 = Price::where('product_uuid', '6ff331cb-00dd-463f-8f5e-f26999cd28d8')
            ->first();

        $this->assertSame('439.00', $price_2->value);
    }

    private function given_i_have_products_without_prices(): void
    {
        ProductData::babyCarriage($this->user);
        ProductData::babyChair($this->user);
    }
}
