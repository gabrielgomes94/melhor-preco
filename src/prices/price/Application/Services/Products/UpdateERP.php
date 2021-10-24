<?php

namespace Src\Prices\Price\Application\Services\Products;

use Src\Prices\Calculator\Application\Transformer\MoneyTransformer;
use Src\Prices\Price\Domain\Contracts\Services\UpdateERP as UpdateERPInterface;
use Src\Products\Domain\Product\Contracts\Models\Post;
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
            $post->getStore()->getSlug(),
            $post->getIdentifiers()->getStoreSkuId(),
            $this->getPrice($post),
        );

        if ($response->hasErrors()) {
            return false;
        }

        return true;
    }

    private function getPrice(Post $post): string
    {
        return MoneyTransformer::toString($post->getPrice()->get());
    }
}
