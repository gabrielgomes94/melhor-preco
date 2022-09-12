<?php

namespace Src\Prices\Domain\DataTransfer;

enum MassCalculationTypes
{
    case Markup;
    case Discount;
    case Addition;
}
