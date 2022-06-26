<?php

namespace Src\Users\Domain\UseCases;

interface GetSynchronizationInfo
{
    public function get(): array;
}
