<?php

namespace Tests\Costs\Feature;

use Src\Users\Infrastructure\Laravel\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Src\Products\Domain\Models\Product\Product;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class LinkProductToPurchaseInvoiceTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = UserData::make();
    }

    public function test_should_link_product_to_purchase_item(): void
    {
        $this->given_i_have_a_product();
        $this->and_given_i_have_a_purchase_item();

        $this->when_i_want_to_link_the_product_to_the_purchase_item();

        $this->then_the_product_must_be_linked_to_purchase_item();
        $this->and_the_user_must_be_redirect();
    }

    private function given_i_have_a_product(): void
    {
        ProductData::makePersisted($this->user, ['sku' => '3600']);
    }

    private function and_given_i_have_a_purchase_item(): void
    {
        $purchaseInvoice = PurchaseInvoiceData::makePersisted($this->user);

        PurchaseItemsData::makePersisted($purchaseInvoice, [
            'uuid' => '517cce8a-e7c2-48d7-a052-5e10729c7c22',
            'product_sku' => null,
        ]);
    }

    private function when_i_want_to_link_the_product_to_the_purchase_item(): void
    {
        $this->response = $this
            ->actingAs($this->user)
            ->put('/custos/notas-fiscais/vincular-item/', [
                'products' => [
                    '517cce8a-e7c2-48d7-a052-5e10729c7c22' => '3600',
                ],
            ]);
    }

    private function then_the_product_must_be_linked_to_purchase_item(): void
    {
        $purchaseInvoice = PurchaseItem::find('517cce8a-e7c2-48d7-a052-5e10729c7c22');
        $product = Product::find('3600');

        $this->assertSame($purchaseInvoice->product_sku, $product->sku);
    }

    private function and_the_user_must_be_redirect(): void
    {
        $this->response->assertRedirect();

    }
}
