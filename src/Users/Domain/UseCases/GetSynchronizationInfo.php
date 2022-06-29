<?php

namespace Src\Users\Domain\UseCases;

interface GetSynchronizationInfo
{
    public function get(string $userId): array;
}
