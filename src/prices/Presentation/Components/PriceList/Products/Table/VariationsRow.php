<?php

namespace Src\Prices\Presentation\Components\PriceList\Products\Table;

use Src\Prices\Presentation\Components\PriceList\Products\ProductComponent;

class VariationsRow extends ProductComponent
{
    public function render()
    {
        return view('components.pricing.price-list.products.store-list.table.variations-row', $this->data);
    }
}
