<?php

namespace Src\Dashboard\Domain\UseCases;

interface GetSynchronizationInfo
{
    public function get(): array;
}
