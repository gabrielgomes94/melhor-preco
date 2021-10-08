<?php

namespace Src\Notifications\Domain\Models;

use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;
use Src\Notifications\Domain\Contracts\Notification as NotificationInterface;

class Notification extends DatabaseNotification implements NotificationInterface
{
    public function markAsSolved(): void
    {
        if (is_null($this->solved_at)) {
            $this->forceFill(['solved_at' => $this->freshTimestamp()])->save();
        }
    }

    public function markAsUnsolved(): void
    {
        if (! is_null($this->solved_at)) {
            $this->forceFill(['solved_at' => null])->save();
        }
    }

    public function id(): ?string
    {
        return $this->id;
    }

    public function identifier(): ?string
    {
        return $this->id;
    }

    public function isRead(): bool
    {
        return (bool) $this->read_at;
    }

    public function isSolved(): bool
    {
        return (bool) $this->solved_at;
    }

    public function content()
    {
        return $this->data['content'] ?? [];
    }

    public function tags(): array
    {
        return $this->data['tags'] ?? [];
    }

    public function title(): string
    {
        return $this->data['title'] ?? '';
    }

    public function category(): string
    {
        return $this->data['type'] ?? '';
    }

    public function type(): string
    {
        return $this->type ?? '';
    }

    public function createdAt(): Carbon
    {
        return $this->created_at;
    }
}
