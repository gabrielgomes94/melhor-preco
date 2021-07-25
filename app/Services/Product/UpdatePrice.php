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

    public function execute(Product $product, Store $store, float $price): bool
    {
        $price = Helpers::floatToMoney($price);

        if (!$post = $product->getPost($store->slug())) {
            return false;
        }

        $price = $this->calculatePrice->calculate($product, $store, $price);
        $post->setPrice($price->get(), $price->profit());

        /**
         * Refatorar repository de atualização
         */
        $this->priceRepository->update($post->id(), $post->price(), $post->profit());

        /**
         * Integrar com o cliente do Bling para atualizar preços
         */
        $this->client->update(
            $product->sku(),
            $store->slug(),
            $price->store_sku_id,
            (string) $price
        );

        return true;
    }
}
