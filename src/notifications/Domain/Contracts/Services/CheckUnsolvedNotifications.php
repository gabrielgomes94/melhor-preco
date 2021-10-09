<?php

namespace Src\Notifications\Domain\Contracts\Services;

interface CheckUnsolvedNotifications
{
    public function check(): void;
}
