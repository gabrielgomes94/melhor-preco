<?php

namespace Src\Prices\Calculator\Presentation\Components;

use Illuminate\View\Component;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Src\Prices\Calculator\Domain\PostPriced\Contracts\HasSecondaryPrice;
use Src\Prices\Calculator\Domain\PostPriced\PostPriced;

abstract class PricesComponent extends Component
{
    public string $productId;
    public array $price;
    protected PostPriced $postPriced;

    public function __construct(PostPriced $price, string $productId)
    {
        $this->postPriced = $price;
        $this->productId = $productId;
        $this->price = array_merge($this->getData(), $this->getSecondaryData());
    }

    /**
     * @inheritDoc
     */
    abstract public function render();

    private function getData(): array
    {
        $moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return [
            'name' => $this->postPriced->product()->name(),
            'sku' => $this->postPriced->product()->sku(),
            'id' => $this->postPriced->post()->id(),
            'store' => $this->postPriced->post()->store()->name(),
            'storeSlug' => $this->postPriced->post()->store()->slug(),
            'value' => $moneyFormatter->format($this->postPriced->post()->price()),
            'profit' => $moneyFormatter->format($this->postPriced->price()->profit()),
            'margin' => $this->postPriced->price()->margin(),
            'commission' => $this->postPriced->post()->store()->commission(),
            'additionalCosts' => $moneyFormatter->format($this->postPriced->price()->additionalCosts()),
        ];
    }

    private function getSecondaryData(): array
    {
        if (!$this->postPriced instanceof HasSecondaryPrice) {
            return [];
        }

        $moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return [
            'secondaryPrice' => [
                'price' => $moneyFormatter->format($this->postPriced->secondaryPrice()->get()),
                'profit' => $moneyFormatter->format($this->postPriced->secondaryPrice()->profit()),
                'margin' => $this->postPriced->secondaryPrice()->margin(),
            ],
        ];
    }
}
