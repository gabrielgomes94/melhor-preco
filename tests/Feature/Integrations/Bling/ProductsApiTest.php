<?php

namespace Tests\Feature\Integrations\Bling;

use Illuminate\Support\Facades\Http;
use Src\Integrations\Bling\Products\Client;
use Src\Integrations\Bling\Products\Responses\Sanitizer;
use Tests\TestCase;

class ProductsApiTest extends TestCase
{
    public function test_should_get_product(): void
    {
        // Set
        $sku = '123';
        $client = $this->setupClient();

        $this->fakeBlingGetProductRequest(
            $sku,
            $this->getJsonFixture('Bling/Products/single-product.json')
        );
        $expected = $this->getJsonFixture('Bling/Products/single-product-sanitized.json');

        // Act
        $result = $client->get($sku);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_should_get_product_with_price(): void
    {
        // Set
        $sku = '123';
        $storeCode = '123456';
        $client = $this->setupClient();

        $this->fakeBlingGetProductRequest(
            $sku,
            $this->getJsonFixture('Bling/Products/single-product-store.json')
        );
        $expected = $this->getJsonFixture('Bling/Products/single-product-store-sanitized.json');

        // Act
        $result = $client->getPrice($sku, $storeCode);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_should_not_get_product(): void
    {
        // Set
        $sku = '000';
        $client = $this->setupClient();

        $this->fakeBlingGetProductRequest(
            $sku,
            $this->getJsonFixture('Bling/Errors/404.json')
        );

        // Act
        $result = $client->get($sku);

        // Assert
        $this->assertSame(['error' => 'A informacao desejada nao foi encontrada'], $result);
    }

    public function test_should_list_products(): void
    {
        // Set
        $client = $this->setupClient();

        $this->fakeBlingListProductsRequest(
            $this->getJsonFixture('Bling/Products/list-products.json')
        );
        $expected = $this->getJsonFixture('Bling/Products/list-products-sanitized.json');

        // Act
        $result = $client->list();

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_should_list_products_with_price(): void
    {
        // Set
        $client = $this->setupClient();
        $storeCode = '123456';
        $this->fakeBlingListProductsRequest(
            $this->getJsonFixture('Bling/Products/list-products-store.json')
        );
        $expected = $this->getJsonFixture('Bling/Products/list-products-store-sanitized.json');

        // Act
        $result = $client->listPrice($storeCode);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_should_not_list_products(): void
    {
        // Set
        $client = $this->setupClient();

        $this->fakeBlingListProductsRequest(
            $this->getJsonFixture('Bling/Errors/404.json')
        );

        // Act
        $result = $client->list(-10);

        // Assert
        $this->assertSame(['error' => 'A informacao desejada nao foi encontrada'], $result);
    }

    public function test_should_update_product(): void
    {
        // Set
        $client = $this->setupClient();
        $sku = '1234';
        $storeCode = '123456';
        $this->fakeBlingUpdateProductRequest(
            $sku,
            $this->getJsonFixture('Bling/Products/single-product.json')
        );
        $expected = $this->getJsonFixture('Bling/Products/single-product-sanitized.json');

        // Act
        $result = $client->update($sku, $storeCode);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_should_update_product_price(): void
    {
        // Set
        $client = $this->setupClient();
        $sku = '1234';
        $storeCode = '123456';
        $productStoreSku = '999888';
        $priceValue = 439.00;

        $this->fakeBlingUpdatePriceRequest($storeCode, $sku);
        $expected = $this->getJsonFixture('Bling/Products/price-updated-sanitized.json');

        // Act
        $result = $client->updatePrice($sku, $storeCode, $productStoreSku, $priceValue);

        // Assert
        $this->assertSame($expected, $result);
    }

    private function fakeBlingGetProductRequest(string $sku, array $bodyResponse): void
    {
        Http::fake([
            "bling.com.br/Api/v2/produto/$sku/*" => Http::response($bodyResponse),
        ]);
    }

    private function fakeBlingListProductsRequest(array $bodyResponse): void
    {
        Http::fake([
            "bling.com.br/Api/v2/produtos/*" => Http::response($bodyResponse),
        ]);
    }

    private function fakeBlingUpdatePriceRequest(string $storeCode, string $sku)
    {
        $bodyResponse = $this->getJsonFixture('Bling/Products/price-updated.json');

        Http::fake([
            "bling.com.br/Api/v2/produtoLoja/$storeCode/$sku/*" => Http::response($bodyResponse),
        ]);
    }

    private function fakeBlingUpdateProductRequest(string $sku, array $bodyResponse): void
    {
        Http::fake([
            "bling.com.br/Api/v2/produto/*" => Http::response($bodyResponse),
        ]);
    }

    private function setupClient(): Client
    {
        config(['integrations.bling.auth.apikey' => 'token']);
        $sanitizer = new Sanitizer();

        return new Client($sanitizer);
    }
}
