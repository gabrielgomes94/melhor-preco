<?php

namespace Src\Prices\Presentation\Components\Products\Table;

use Src\Prices\Presentation\Components\Products\ProductComponent;

class ProductRow extends ProductComponent
{
    public function render()
    {
        return view('components.app.pricing.price-list.products.store-list.table.product-row', $this->data);
    }
}
