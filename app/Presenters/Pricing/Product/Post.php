<?php

namespace App\Presenters\Pricing\Product;

use Barrigudinha\Pricing\PostPriced;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

class Post
{
    private DecimalMoneyFormatter $moneyFormatter;

    public string $id;
    public string $store;
    public string $storeSlug;
    public string $commission;
    public string $value;
    public string $profit;
    public string $margin;
    public string $additionalCosts;

    public function __construct(PostPriced $postPriced)
    {
        $this->moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        $this->id = $postPriced->post()->id();
        $this->store = $postPriced->post()->store()->name();
        $this->storeSlug = $postPriced->post()->store()->slug();
        $this->value = $this->moneyFormatter->format($postPriced->post()->price());
        $this->profit = $this->moneyFormatter->format($postPriced->price()->profit());
        $this->margin = $postPriced->price()->margin() * 100;
        $this->commission = $postPriced->post()->store()->commission();
        $this->additionalCosts = $this->moneyFormatter->format($postPriced->price()->additionalCosts());
    }
}
