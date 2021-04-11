<?php

namespace App\Repositories\Pricing;

use App\Models\Price;
use App\Models\Product as ProductModel;
use Barrigudinha\Pricing\Data\Product as PricingProduct;
use Barrigudinha\Product\Product;
use Barrigudinha\Pricing\Repositories\Contracts\Product as RepositoryContract;
use Integrations\Bling\Products\StoreClient;

class ProductRepository implements RepositoryContract
{
    private StoreClient $client;

//    private $createRepository;

    public function __construct(StoreClient $client)
    {
        $this->client = $client;
    }

    public function get(string $sku): ?PricingProduct
    {
        if ($model = $this->findInDB($sku)) {
            return new PricingProduct($model->toArray());
        }

        $response = $this->client->getWithStores($sku, ['magalu', 'b2w', 'mercado_livre']);
        if (!$product = $response->product()) {
            return null;
        }

        $model = $this->createFromBling($product);

        return new PricingProduct($model->toArray());
    }

    private function createFromBling(Product $product): ProductModel
    {
        $model = new ProductModel([
            'sku' => $product->sku,
            'name' => $product->name,
            'purchase_price' => $product->purchasePrice,
            'tax_ipi' => 0.0,
            'tax_icms' => 0.0,
            'tax_simples_nacional' => 0.0,
        ]);
        $model->save();

        foreach($product->stores ?? [] as $store) {
            $price = new Price([
                'commission' => 12.1,
                'profit' => 0.0,
                'store' => $store->code(),
                'store_sku_id' => $store->store_sku_id(),
                'value' => $store->price(),
            ]);


            $model->prices()->save($price);
        }

        return $model;
    }

    private function findInDB(string $sku)
    {
        return ProductModel::where('sku', $sku)->first();
    }
}
