<?php

namespace Src\Prices\Price\Presentation\Components\Products;

//use Src\Products\Domain\Entities\Product;
use Illuminate\View\Component;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\MoneyFormatter;
use Src\Prices\Calculator\Application\Transformer\MoneyTransformer;
use Src\Products\Domain\Product\Contracts\Models\Product;
use Src\Products\Domain\Product\Models\Data\ProductData as ProductData;

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
        $data = $this->product->data();

        $this->data = [
            'sku' => $data->getSku(),
            'name' => $data->getDetails()->getName(),
            'price' => $this->getPrice($data),
            'profit' => $this->getProfit($data),
            'margin' => $this->getMargin($data),
            'store' => $this->store,
        ];
    }

    private function getPrice(ProductData $productData): string
    {
        if (!$post = $productData->getPost($this->store)) {

            return '';
        }

        return MoneyTransformer::toString($post->getPrice()->get());
    }

    private function getProfit(ProductData $productData): string
    {
        if (!$post = $productData->getPost($this->store)) {
            return '';
        }

        return MoneyTransformer::toString($post->getPrice()->getProfit());
    }

    private function getMargin(ProductData $productData): string
    {
        $post = $productData->getPost($store ?? $this->store);

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
