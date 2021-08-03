<?php

namespace App\Services\Pricing;

use App\Repositories\Pricing\Price\Repository;
use Barrigudinha\Product\Entities\Post;
use Integrations\Bling\Products\Clients\ProductStore;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

class UpdatePrice
{
    private Repository $priceRepository;
    private ProductStore $client;
    private DecimalMoneyFormatter $formatter;

    public function __construct(Repository $priceRepository, ProductStore $client)
    {
        $this->priceRepository = $priceRepository;
        $this->client = $client;
        $this->formatter = new DecimalMoneyFormatter(new ISOCurrencies());
    }

    public function execute(string $sku, Post $post): bool
    {
        if (!$priceModel = $this->priceRepository->get($post->id())) {
            return false;
        }

        $result = $this->priceRepository->update($priceModel, $post->price(), $post->profit());
        $price = $this->formatter->format($post->price());


        if (!$result) {
            return false;
        }

        if (config('features.integrations.bling.update_price.enabled')) {
            $this->client->update(
                $sku,
                $post->store()->slug(),
                $priceModel->store_sku_id,
                $price
            );
        }

        return true;
    }
}
