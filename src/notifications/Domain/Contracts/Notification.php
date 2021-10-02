<?php

namespace Src\Notifications\Domain\Contracts;

use Carbon\Carbon;

interface Notification
{
    public function id(): ?string;

    public function isRead(): bool;

    public function isSolved(): bool;

    public function content(): string;

    public function tags(): array;

    public function title(): string;

    public function createdAt(): Carbon;
}
