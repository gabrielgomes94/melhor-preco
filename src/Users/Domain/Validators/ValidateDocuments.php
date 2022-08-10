<?php

namespace Src\Users\Domain\Validators;

class ValidateDocuments
{
    public static function validateCPF(string $value): bool
    {
        $c = preg_replace('/\D/', '', $value);

        if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            return false;
        }

        for (
            $s = 10, $n = 0, $i = 0;
            $s >= 2;
            $n += $c[$i++] * $s--
        );

        if ($c[9] != self::getVerifyingDigit($n)) {
            return false;
        }

        for (
            $s = 11, $n = 0, $i = 0;
            $s >= 2;
            $n += $c[$i++] * $s--
        );

        if ($c[10] != self::getVerifyingDigit($n)) {
            return false;
        }

        return true;
    }

    public static function validateCNPJ(string $value): bool
    {
        $c = preg_replace('/\D/', '', $value);

        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        if (strlen($c) != 14) {
            return false;
        }

        for (
            $i = 0, $n = 0;
            $i < 12;
            $n += $c[$i] * $b[++$i]
        );

        if ($c[12] != self::getVerifyingDigit($n)) {
            return false;
        }

        for (
            $i = 0, $n = 0;
            $i <= 12;
            $n += $c[$i] * $b[$i++]
        );

        if ($c[13] != self::getVerifyingDigit($n)) {
            return false;
        }

        return true;
    }

    private static function getVerifyingDigit(int $n): int
    {
        return (($n %= 11) < 2) ? 0 : 11 - $n;
    }
}
