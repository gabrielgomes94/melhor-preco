<?php

namespace Src\Prices\Presentation\Components\Products;

use Illuminate\View\Component;
use Src\Math\MoneyTransformer;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Repositories\Contracts\PostRepository;

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
            'quantity' => $this->product->quantity,
        ];
    }

    private function getPrice(): string
    {
        $postRepository = app(PostRepository::class);
        $post = $postRepository->getByMarketplaceSlug($this->product, $this->store);

        if (!$post) {
            return '';
        }

        return MoneyTransformer::toString($post->getCalculatedPrice()->get());
    }

    private function getProfit(): string
    {
        $postRepository = app(PostRepository::class);
        $post = $postRepository->getByMarketplaceSlug($this->product, $this->store);

        if (!$post) {
            return '';
        }

        return MoneyTransformer::toString($post->getCalculatedPrice()->getProfit());
    }

    private function getMargin(): string
    {
        $postRepository = app(PostRepository::class);
        $post = $postRepository->getByMarketplaceSlug($this->product, $this->store);

        if (!$post) {
            return '';
        }

        $price = $post->getCalculatedPrice();

        if ($price->get()->isZero()) {
            return '0.0';
        }


        $margin = $price->getProfit()->ratioOf($price->get()) * 100;

        return round($margin, 2);
    }
}
