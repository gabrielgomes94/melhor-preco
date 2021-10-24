<?php

namespace Src\Prices\Calculator\Presentation\Components\UpdateCosts;

use Illuminate\View\Component;
use Src\Products\Domain\Product\Models\Data\ProductData;

class Form extends Component
{
    private ProductData $product;

    public function __construct(ProductData $product)
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
