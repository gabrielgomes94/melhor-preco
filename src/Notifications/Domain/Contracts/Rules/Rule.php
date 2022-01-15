<?php

namespace Src\Notifications\Domain\Contracts\Rules;

interface Rule
{
    public function isSolved(array $data): bool;
}
