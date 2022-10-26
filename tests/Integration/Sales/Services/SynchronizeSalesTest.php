<?php

namespace Tests\Integration\Sales\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;
use Src\Sales\Application\Services\SynchronizeSales;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Sales\SaleItemData;
use Tests\Data\Models\Sales\SaleOrderData;
use Tests\Data\Models\Users\UserData;
use Tests\Feature\Users\Concerns\UsersDatabase;
use Tests\TestCase;

class SynchronizeSalesTest extends TestCase
{
    use RefreshDatabase;
    use UsersDatabase;

    private User $user;

    public function test_should_insert_new_sales(): void
    {
        $this->given_i_am_a_logged_user();
        $this->and_given_i_have_a_marketplace();
        $this->and_given_i_have_some_products();
        $this->and_given_i_have_sales_integration_on_bling_setup();

        $this->when_i_want_to_synchronize_sales();

        $this->then_i_must_have_the_sales_persisted_in_database();
    }

    public function test_should_update_sales(): void
    {
        $this->given_i_am_a_logged_user();
        $this->and_given_i_have_a_marketplace();
        $this->and_given_i_have_some_products();
        $this->and_given_i_have_sales_integration_on_bling_setup();
        $this->and_given_i_have_a_sale_synchronized();

        $this->when_i_want_to_synchronize_sales();

        $this->then_the_sale_status_must_be_updated();
    }

    public function test_should_handle_when_sale_was_not_synchronized(): void
    {
        $this->given_i_am_a_logged_user();

        $this->when_i_want_to_synchronize_sales();

        $this->when_i_want_to_synchronize_sales();
    }

    private function and_given_i_have_a_marketplace(): void
    {
        MarketplaceData::magalu($this->user);
    }

    private function and_given_i_have_some_products(): void
    {
        ProductData::babyCarriage($this->user);
        ProductData::babyChair($this->user);
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

        $service->sync($this->user);
    }

    private function then_i_must_have_the_sales_persisted_in_database(): void
    {
        $saleOrder = SaleOrder::where('user_id', $this->user->getId())
            ->get();

        $this->assertCount(1, $saleOrder);
        $this->assertInstanceOf(Marketplace::class, $saleOrder->first()->getMarketplace());
    }

    private function and_given_i_have_a_sale_synchronized(): void
    {
        $productBabyPacifier = Product::where('sku', '1234')
            ->where('user_id', $this->user->getId())
            ->first();

        SaleOrderData::persisted(
            $this->user,
            [
                'sale_order_id' => '1',
                'purchase_order_id' => '100000001',
                'status' => 'Aguardando pagamento',
            ],
            [
                SaleItemData::make($productBabyPacifier),
            ],
        );
    }

    private function then_the_sale_status_must_be_updated(): void
    {
        $saleOrder = SaleOrder::where('user_id', $this->user->getId())
            ->where('sale_order_id', '1')
            ->first();

        $this->assertSame('Em Aberto', (string) $saleOrder->getStatus());
    }
}
