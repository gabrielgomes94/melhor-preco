<?php

namespace Src\Prices\PriceList\Presentation\Components\Products\Table;

use Src\Prices\PriceList\Presentation\Components\Products\ProductComponent;

class ProductRow extends ProductComponent
{
    public function render()
    {
        return view('components.pricing.price-list.products.store-list.table.product-row', $this->data);
    }
}
