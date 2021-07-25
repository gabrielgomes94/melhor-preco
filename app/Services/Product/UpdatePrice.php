<?php

namespace App\Services\Product;

use App\Repositories\Pricing\Price\Repository;
use Barrigudinha\Pricing\Price\Services\CalculatePrice;
use Barrigudinha\Product\Product;
use Barrigudinha\Product\Store;
use Barrigudinha\Utils\Helpers;
use Integrations\Bling\Products\Clients\ProductStore;

class UpdatePrice
{
    private Repository $priceRepository;
    private CalculatePrice $calculatePrice;
    private ProductStore $client;

    public function __construct(Repository $priceRepository, CalculatePrice $calculatePrice, ProductStore $client)
    {
        $this->priceRepository = $priceRepository;
        $this->calculatePrice = $calculatePrice;
        $this->client = $client;
    }

    public function execute(Product $product, Store $store, float $priceValue): bool
    {
        $priceValue = Helpers::floatToMoney($priceValue);
        $products[] = $this->getProducts($product);

        foreach ($products as $product) {
            if (!$post = $product->getPost($store->slug())) {
                return false;
            }

            $price = $this->calculatePrice->calculate($product, $store, $priceValue);
            $post->setPrice($price->get(), $price->profit());
            $this->priceRepository->update($post->id(), $post->price(), $post->profit());

            if (config('features.integrations.bling.update_price.enabled')) {
                $this->client->update(
                    $product->sku(),
                    $store->slug(),
                    $price->store_sku_id,
                    (string) $price
                );
            }
        }

        return true;
    }

    /**
     * @return Product[]
     */
    private function getProducts(Product $product): array
    {
        $products[] = $product;

        foreach ($product->variations()->get() as $variation) {
            $products[] = $variation;
        }

        return $products;
    }
}
