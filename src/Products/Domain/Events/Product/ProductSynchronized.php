<?php

namespace Src\Products\Domain\Events\Product;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductSynchronized
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $productSku;

    public function __construct(string $productSku)
    {
        $this->productSku = $productSku;
    }

    public function getProductSku(): string
    {
        return $this->productSku;
    }
}
