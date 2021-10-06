<?php

namespace Src\Prices\Presentation\Components\Prices\UpdateCosts;

use Barrigudinha\Product\Entities\Product;
use Illuminate\View\Component;

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
            'sku' => $this->product->sku(),
            'purchasePrice' => $this->product->costs()->purchasePrice(),
            'taxICMS' => $this->product->costs()->taxICMS(),
            'additionalCosts' => $this->product->costs()->additionalCosts(),
        ]);
    }
}
