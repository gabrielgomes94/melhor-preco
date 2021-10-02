<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
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

    public function content(): string
    {
        return $this->data['content'] ?? '';
    }

    public function tags(): array
    {
        return $this->data['tags'] ?? [];
    }

    public function title(): string
    {
        return $this->data['title'] ?? '';
    }

    public function createdAt()
    {
        return $this->created_at;
    }
}
