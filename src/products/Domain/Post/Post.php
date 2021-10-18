<?php

namespace Src\Products\Domain\Post;

use Src\Products\Domain\Post\Identifiers\Identifiers;
use Src\Products\Domain\Product\Contracts\Models\Post as PostInterface;
use Src\Products\Domain\Store\Store;

class Post implements PostInterface
{
    protected float $commission;
    protected float $price;
    protected float $profit;
    protected Identifiers $identifiers;
    protected Store $store;

    public function __construct(Identifiers $identifiers, Store $store, float $price, float $profit)
    {
        $this->identifiers = $identifiers;
        $this->store = $store;
        $this->price = $price;
        $this->profit = $profit;
    }

    public function getId(): string
    {
        return $this->identifiers->getId();
    }

    public function getStore(): Store
    {
        return $this->store;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getProfit(): float
    {
        return $this->profit;
    }

    public function getCommission(): float
    {
        return $this->commission;
    }
}
