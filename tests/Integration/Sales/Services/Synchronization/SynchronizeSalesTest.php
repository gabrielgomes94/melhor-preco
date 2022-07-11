<?php

namespace Tests\Integration\Sales\Services\Synchronization;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;
use Src\Sales\Infrastructure\Laravel\Services\SynchronizeSales;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class SynchronizeSalesTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function test_should_insert_new_sales(): void
    {
        $this->given_i_have_an_user();
        $this->and_given_i_have_a_marketplace();
        $this->and_given_i_have_some_products();
        $this->and_given_i_have_sales_integration_on_bling_setup();

        $this->when_i_want_to_synchronize_sales();

        $this->then_i_must_have_the_sales_persisted_in_database();
    }

    public function test_should_update_sales(): void
    {
    }

    public function test_should_handle_when_sale_was_not_synchronized(): void
    {
    }

    private function given_i_have_an_user(): void
    {
        $this->user = UserData::make();
    }

    private function and_given_i_have_a_marketplace(): void
    {
        MarketplaceData::persisted($this->user, [
            'erp_id' => '123456789',
        ]);
    }

    private function and_given_i_have_some_products(): void
    {
        ProductData::makePersisted($this->user, ['sku' => 'CN01']);
        ProductData::makePersisted($this->user, ['sku' => '23541']);
    }

    private function and_given_i_have_sales_integration_on_bling_setup(): void
    {
        $response = $this->getJsonFixture('Bling/SaleOrders/list-sale-orders.json');

        Http::fake([
            'bling.com.br/Api/v2/pedidos/*' => Http::sequence()
                ->push($response)
                ->push([]),
        ]);
    }

    private function when_i_want_to_synchronize_sales(): void
    {
        $service = $this->app->get(SynchronizeSales::class);

        $service->sync($this->user->getId());
    }

    private function then_i_must_have_the_sales_persisted_in_database(): void
    {
        $saleOrder = SaleOrder::where('user_id', $this->user->getId())
            ->get();

        $this->assertCount(1, $saleOrder);
    }
}
