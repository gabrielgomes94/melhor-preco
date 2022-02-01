<?php

namespace Src\Products\Domain\Models\Post;

use Money\Money;
use Src\Calculator\Domain\Transformer\PercentageTransformer;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Calculator\Domain\Models\Price\Price;
use Src\Products\Domain\Models\Post\Identifiers\Identifiers;
use Src\Products\Domain\Models\Product\Contracts\Post as PostInterface;

class Post implements PostInterface
{
    protected Price $price;
    protected float $profit;
    protected Identifiers $identifiers;
    protected ?Marketplace $marketplace;

    public function __construct(Identifiers $identifiers, Marketplace $marketplace, Price $price)
    {
        $this->identifiers = $identifiers;
        $this->price = $price;
        $this->marketplace = $marketplace;
    }

    public function getId(): string
    {
        return $this->identifiers->getId();
    }

    public function getIdentifiers(): Identifiers
    {
        return $this->identifiers;
    }

    public function getMarketplace(): Marketplace
    {
        return $this->marketplace;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function isProfitable(): bool
    {
        return $this->price->getProfit()->greaterThanOrEqual(Money::BRL(0));
    }

    public function isInMarginRange(float $minimumProfit, float $maximumProfit)
    {
        $minimumProfit = PercentageTransformer::toPercentage($minimumProfit);
        $maximumProfit = PercentageTransformer::toPercentage($maximumProfit);
        $margin = $this->getPrice()->getMargin();

        return $minimumProfit <= $margin && $margin <= $maximumProfit;
    }
}
