<?php

namespace Src\Math;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money as MoneyPHP;
use Money\MoneyFormatter;

class Money
{
    private MoneyFormatter $formatter;
    private MoneyPHP $value;

    public function __construct(MoneyPHP $value)
    {
        $this->value = $value;

        $this->formatter = new IntlMoneyFormatter(
            new \NumberFormatter('pt_BR', \NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );;
    }

    public function __toString(): string
    {
        return $this->formatter->format($this->value);
    }

    public static function fromFloat(float $value): self
    {
        $value = MoneyPHP::BRL((int) ($value * 100));

        return new self($value);
    }

    public static function fromMoneyPHP(MoneyPHP $value): self
    {
        return new self($value);
    }

    public function get(): MoneyPHP
    {
        return $this->value;
    }

    public function toFloat(): float
    {
        return (float) $this->toString();
    }
}
