<?php

namespace Src\Sales\Domain\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Src\Sales\Domain\Events\Contracts\ModelSynchronized;
use Src\Sales\Domain\Models\Customer;

class CustomerSynchronized implements ModelSynchronized
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $customerId;

    public function __construct(string $customerId)
    {
        $this->customerId = $customerId;
    }

    public function getModel(): Model
    {
        return Customer::find($this->customerId);
    }
}
