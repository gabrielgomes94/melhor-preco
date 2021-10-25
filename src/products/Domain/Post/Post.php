<?php

namespace Src\Products\Domain\Post;

use Src\Prices\Calculator\Domain\Transformer\PercentageTransformer;
use Src\Prices\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Prices\Calculator\Domain\Price\Price;
use Src\Products\Domain\Post\Identifiers\Identifiers;
//use Src\Products\Domain\Product\Contracts\Models\Data\Price\Price;
use Src\Products\Domain\Product\Contracts\Models\Post as PostInterface;
use Src\Products\Domain\Store\Store;

class Post implements PostInterface
{
    protected Price $price;
    protected float $profit;
    protected Identifiers $identifiers;
    protected Store $store;

    public function __construct(Identifiers $identifiers, Store $store, Price $price)
    {
        $this->identifiers = $identifiers;
        $this->store = $store;
        $this->price = $price;
    }

    public function getId(): string
    {
        return $this->identifiers->getId();
    }

    public function getIdentifiers(): Identifiers
    {
        return $this->identifiers;
    }

    public function getStore(): Store
    {
        return $this->store;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function isInMarginRange(float $minimumProfit, float $maximumProfit)
    {
        $minimumProfit = PercentageTransformer::toPercentage($minimumProfit);
        $maximumProfit = PercentageTransformer::toPercentage($maximumProfit);
        $margin = $this->getPrice()->getMargin();

        return $minimumProfit <= $margin && $margin <= $maximumProfit;
    }
}
