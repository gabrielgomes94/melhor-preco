<?php

namespace Src\Products\Domain\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class ProductWasNotSynchronized
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getData()
    {
        return $this->product->toArray();
    }
}
