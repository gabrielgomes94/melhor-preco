<?php

namespace Src\Products\Domain\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductImagesUploaded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(string $sku)
    {

    }
}
