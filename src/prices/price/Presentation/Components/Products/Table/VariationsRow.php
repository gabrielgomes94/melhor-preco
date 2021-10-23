<?php

namespace Src\Prices\Price\Presentation\Components\Products\Table;

use Src\Prices\Price\Presentation\Components\Products\ProductComponent;

class VariationsRow extends ProductComponent
{
    public function render()
    {
        return view('components.pricing.price-list.products.store-list.table.variations-row', $this->data);
    }
}
