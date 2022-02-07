<?php

namespace Src\Prices\Application\Services\Products;

use Src\Integrations\Bling\Products\Client;
use Src\Math\MoneyTransformer;
use Src\Prices\Domain\Contracts\Services\UpdateERP as UpdateERPInterface;
use Src\Products\Domain\Models\Product\Contracts\Post;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Src\Products\Infrastructure\Bling\Responses\Product\Factory;

class UpdateERP implements UpdateERPInterface
{
    private DecimalMoneyFormatter $formatter;
    private Client $client;
    private Factory $factory;

    public function __construct(Client $client, Factory $factory)
    {
        $this->client = $client;
        $this->factory = $factory;
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
            $post->getMarketplace()->getErpId(),
            $post->getIdentifiers()->getStoreSkuId(),
            $this->getPrice($post),
        );
        $response = $this->factory->make($response);

        if ($response->hasErrors()) {
            return false;
        }

        return true;
    }

    private function getPrice(Post $post): string
    {
        return MoneyTransformer::toString($post->getCalculatedPrice()->get());
    }
}
