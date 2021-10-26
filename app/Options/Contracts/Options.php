<?php

namespace App\Options\Contracts;

interface Options
{
    public function page(): ?int;
    public function perPage(): ?int;
    public function query(): array;
    public function url(): string;
}
