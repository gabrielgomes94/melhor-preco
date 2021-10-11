<?php

namespace Src\Prices\Application\Services\UpdatePrice;

use Src\Prices\Domain\Contracts\Services\UpdatePrice\UpdateERP as UpdateERPInterface;
use Src\Products\Domain\Entities\Post;
use Integrations\Bling\Products\Clients\ProductStore;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

class UpdateERP implements UpdateERPInterface
{
    private DecimalMoneyFormatter $formatter;
    private ProductStore $client;

    public function __construct(ProductStore $client)
    {
        $this->client = $client;
        $this->formatter = new DecimalMoneyFormatter(new ISOCurrencies());
    }

    public function execute(string $sku, Post $post): bool
    {
        // To Do: criar feature repository
        if (!config('features.integrations.bling.update_price.enabled')) {
            return true;
        }

        $response = $this->client->updatePrice(
            $sku,
            $post->store()->slug(),
            $post->store()->storeSkuId(),
            $this->getPrice($post),
        );

        if ($response->hasErrors()) {
            return false;
        }

        return true;
    }

    private function getPrice(Post $post): string
    {
        return $this->formatter->format($post->price());
    }
}
