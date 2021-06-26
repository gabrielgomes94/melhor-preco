<?php

namespace App\Presenters\Pricing\Post;

use Barrigudinha\Pricing\Data\PostPriced\PostPriced;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

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
    public string $name;
    public string $sku;

    public function __construct(PostPriced $postPriced)
    {
        $this->moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        $this->name = $postPriced->product()->name();
        $this->sku = $postPriced->product()->sku();


        $this->id = $postPriced->post()->id();
        $this->store = $postPriced->post()->store()->name();
        $this->storeSlug = $postPriced->post()->store()->slug();
        $this->value = $this->moneyFormatter->format($postPriced->post()->price());
        $this->profit = $this->moneyFormatter->format($postPriced->price()->profit());
        $this->margin = $postPriced->price()->margin() * 100;
        $this->commission = $postPriced->post()->store()->commission();
        $this->additionalCosts = $this->moneyFormatter->format($postPriced->price()->additionalCosts());
    }

    protected function formatMoney(Money $value): string
    {
        return $this->moneyFormatter->format($value);
    }
}
