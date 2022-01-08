<?php

namespace Src\Prices\Calculator\Presentation\Components\UpdateCosts;

use Illuminate\View\Component;
use Src\Products\Domain\Models\Product\Product;

class Form extends Component
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function render()
    {
        $costs = $this->product->getCosts();

        return view('components.app.pricing.prices.update-costs.form', [
            'sku' => $this->product->getSku(),
            'purchasePrice' => $costs->purchasePrice(),
            'taxICMS' => $costs->taxICMS(),
            'additionalCosts' => $costs->additionalCosts(),
        ]);
    }
}
