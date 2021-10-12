<?php

namespace Src\Prices\Presentation\Components\PriceList\Products;

use Src\Products\Domain\Entities\Product;
use Illuminate\View\Component;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\MoneyFormatter;

abstract class ProductComponent extends Component
{
    private Product $product;
    private string $store;
    private MoneyFormatter $moneyFormatter;

    public array $data;

    public function __construct(Product $product, string $store = '')
    {
        $this->product = $product;
        $this->store = $store;
        $this->moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        $this->setData();
    }

    /**
     * @inheritDoc
     */
    abstract public function render();

    private function setData(): void
    {
        $this->data = [
            'sku' => $this->product->sku(),
            'name' => $this->product->name(),
            'price' => $this->getPrice(),
            'profit' => $this->getProfit(),
            'margin' => $this->getMargin(),
            'store' => $this->store,
        ];
    }

    private function getPrice(): string
    {
        if (!$post = $this->product->getPost($this->store)) {
            return '';
        }

        return $this->moneyFormatter->format($post->price());
    }

    private function getProfit(): string
    {
        if (!$post = $this->product->getPost($this->store)) {
            return '';
        }

        return $this->moneyFormatter->format($post->profit());
    }

    private function getMargin(): string
    {
        $post = $this->product->getPost($store ?? $this->store);

        if (!$post) {
            return '';
        }

        if ($post->price()->isZero()) {
            return '0.0';
        }

        $margin = $post->profit()->ratioOf($post->price()) * 100;

        return round($margin, 2);
    }
}
