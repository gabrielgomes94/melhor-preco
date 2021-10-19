<?php

namespace Src\Prices\Calculator\Presentation\Components\UpdateCosts;

use Illuminate\View\Component;
use Src\Products\Domain\Product\Models\Data\Product;

class Form extends Component
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return view('components.pricing.prices.update-costs.form', [
            'sku' => $this->product->getSku(),
            'purchasePrice' => $this->product->getCosts()->purchasePrice(),
            'taxICMS' => $this->product->getCosts()->taxICMS(),
            'additionalCosts' => $this->product->getCosts()->additionalCosts(),
        ]);
    }
}
