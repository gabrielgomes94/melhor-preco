<?php

namespace Src\Prices\Presentation\Components\Products;

use Illuminate\View\Component;
use Src\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Products\Domain\Models\Product\Product;

abstract class ProductComponent extends Component
{
    private Product $product;
    private string $store;
    public array $data;

    public function __construct(Product $product, string $store = '')
    {
        $this->product = $product;
        $this->store = $store;

        $this->setData();
    }

    abstract public function render();

    private function setData(): void
    {
        $this->data = [
            'sku' => $this->product->getSku(),
            'name' => $this->product->getDetails()->getName(),
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

        return MoneyTransformer::toString($post->getPrice()->get());
    }

    private function getProfit(): string
    {
        if (!$post = $this->product->getPost($this->store)) {
            return '';
        }

        return MoneyTransformer::toString($post->getPrice()->getProfit());
    }

    private function getMargin(): string
    {
        $post = $this->product->getPost($store ?? $this->store);

        if (!$post) {
            return '';
        }

        $price = $post->getPrice();

        if ($price->get()->isZero()) {
            return '0.0';
        }


        $margin = $price->getProfit()->ratioOf($price->get()) * 100;

        return round($margin, 2);
    }
}
