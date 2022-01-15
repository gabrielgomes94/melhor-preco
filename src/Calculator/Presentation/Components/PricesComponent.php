<?php

namespace Src\Calculator\Presentation\Components;

use Illuminate\View\Component;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Src\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Products\Domain\Models\Post\Contracts\HasSecondaryPrice;
use Src\Products\Domain\Models\Product\Contracts\Product;
use Src\Products\Domain\Models\Product\Contracts\Post;

abstract class PricesComponent extends Component
{
    public string $productId;
    public Post $post;
    public Product $product;
    public array $price;

    public function __construct(Post $post, Product $product)
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
