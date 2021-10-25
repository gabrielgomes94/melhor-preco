<?php

namespace Src\Prices\Calculator\Presentation\Components;

use Illuminate\View\Component;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Src\Prices\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Products\Domain\Post\Contracts\HasSecondaryPrice;
use Src\Products\Domain\Product\Contracts\Models\Post;
use Src\Products\Domain\Product\Models\Data\ProductData;

abstract class PricesComponent extends Component
{
    public string $productId;
    public Post $post;
    public ProductData $product;
    public array $price;

    public function __construct(Post $post, ProductData $product)
    {
        $this->post = $post;
        $this->product = $product;
        $this->productId = $product->getSku();

        $this->price = $this->getData();
    }

    /**
     * @inheritDoc
     */
    abstract public function render();

    protected function getData(): array
    {
        $moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        $data = [
            'name' => $this->product->getDetails()->getName(),
            'sku' => $this->product->getSku(),
            'id' => $this->post->getId(),
            'store' => $this->post->getStore()->getName(),
            'storeSlug' => $this->post->getStore()->getSlug(),
            'mainPrice' => [
                'value' => MoneyTransformer::toFloat($this->post->getPrice()->get()),
                'profit' => MoneyTransformer::toFloat($this->post->getPrice()->getProfit()),
                'margin' => $this->post->getPrice()->getMargin(),
                'commission' => MoneyTransformer::toFloat($this->post->getPrice()->getCommission()->get()),
            ],
        ];

        if ($this->post instanceof HasSecondaryPrice) {
            $secondaryPrice = [
                'secondaryPrice' => [
                    'value' => $moneyFormatter->format($this->post->getSecondaryPrice()->get()),
                    'profit' => $moneyFormatter->format($this->post->getSecondaryPrice()->getProfit()),
                    'margin' => $this->post->getSecondaryPrice()->getMargin(),
                ],
            ];

            return array_merge($data, $secondaryPrice);
        }

        return $data;
    }
}
