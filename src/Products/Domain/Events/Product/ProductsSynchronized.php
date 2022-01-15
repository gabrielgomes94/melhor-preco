<?php

namespace Src\Products\Domain\Events\Product;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductsSynchronized
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $userId;
    private int $createdCount;
    private int $updatedCount;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $userId, int $createdCount, int $updatedCount)
    {
        $this->userId = $userId;
        $this->createdCount = $createdCount;
        $this->updatedCount = $updatedCount;
    }

    public function createdCount(): int
    {
        return $this->createdCount;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function updatedCount(): int
    {
        return $this->updatedCount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
