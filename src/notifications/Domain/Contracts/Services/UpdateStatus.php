<?php

namespace Src\Notifications\Domain\Contracts\Services;

interface UpdateStatus
{
    public function toggleReadingStatus(string $id): bool;

    public function toggleSolvedStatus(string $id, bool $value = true): bool;
}
