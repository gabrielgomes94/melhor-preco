<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Components\Products\Table;

use Src\Prices\Infrastructure\Laravel\Presentation\Components\Products\ProductComponent;

class VariationsRow extends ProductComponent
{
    public function render()
    {
        return view('components.app.pricing.price-list.products.store-list.table.variations-row', $this->data);
    }
}
