<?php

namespace Barrigudinha\Utils\Paginator\Contracts;

interface Options
{
    public function page(): ?int;
    public function perPage(): ?int;
    public function query(): array;
    public function url(): string;
}
