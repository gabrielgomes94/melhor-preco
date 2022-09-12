<?php

namespace Src\Notifications\Domain\Contracts\Repository;

interface Options
{
    public function main(): string;

    public function type(): string;

    public function page(): ?int;
    public function perPage(): ?int;
    public function query(): array;
    public function url(): string;
}
