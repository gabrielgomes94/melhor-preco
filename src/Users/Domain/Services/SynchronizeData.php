<?php

namespace Src\Users\Domain\Services;

interface SynchronizeData
{
    public function execute(string $userId);
}
