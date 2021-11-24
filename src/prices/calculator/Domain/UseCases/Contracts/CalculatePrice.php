<?php

namespace Src\Prices\Calculator\Domain\UseCases\Contracts;

interface CalculatePrice
{
    public function calculate(array $data): array;
}
