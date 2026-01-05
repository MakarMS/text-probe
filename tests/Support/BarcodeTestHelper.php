<?php

namespace Tests\Support;

class BarcodeTestHelper
{
    public static function makeEan13(string $body12): string
    {
        return $body12 . self::calculateEan13CheckDigit($body12);
    }

    public static function makeUpcA(string $body11): string
    {
        return $body11 . self::calculateUpcACheckDigit($body11);
    }

    public static function calculateEan13CheckDigit(string $body12): int
    {
        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $digit = (int) $body12[$i];
            $sum += ($i % 2 === 0) ? $digit : $digit * 3;
        }

        return (10 - ($sum % 10)) % 10;
    }

    public static function calculateUpcACheckDigit(string $body11): int
    {
        $sum = 0;
        for ($i = 0; $i < 11; $i++) {
            $digit = (int) $body11[$i];
            $sum += ($i % 2 === 0) ? $digit * 3 : $digit;
        }

        return (10 - ($sum % 10)) % 10;
    }
}
