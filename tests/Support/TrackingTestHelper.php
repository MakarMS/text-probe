<?php

namespace Tests\Support;

class TrackingTestHelper
{
    private const UPS_LETTER_MAP = [
        'A' => 2,
        'B' => 3,
        'C' => 4,
        'D' => 5,
        'E' => 6,
        'F' => 7,
        'G' => 8,
        'H' => 9,
        'I' => 1,
        'J' => 2,
        'K' => 3,
        'L' => 4,
        'M' => 5,
        'N' => 6,
        'O' => 7,
        'P' => 8,
        'Q' => 9,
        'R' => 1,
        'S' => 2,
        'T' => 3,
        'U' => 4,
        'V' => 5,
        'W' => 6,
        'X' => 7,
        'Y' => 8,
        'Z' => 9,
    ];

    private const S10_WEIGHTS = [8, 6, 4, 2, 3, 5, 9, 7];

    public static function makeUps1Z(string $bodyWithoutCheck): string
    {
        return $bodyWithoutCheck . self::calculateUps1ZCheckDigit($bodyWithoutCheck);
    }

    public static function makeS10(string $prefix, string $serial8, string $country): string
    {
        return strtoupper($prefix) . $serial8 . self::calculateS10CheckDigit($serial8) . strtoupper($country);
    }

    public static function calculateUps1ZCheckDigit(string $bodyWithoutCheck): int
    {
        $bodyWithoutCheck = strtoupper($bodyWithoutCheck);
        $sum = 0;
        $weight = 2;

        for ($i = strlen($bodyWithoutCheck) - 1; $i >= 0; $i--) {
            $char = $bodyWithoutCheck[$i];
            $value = ctype_digit($char) ? (int) $char : self::UPS_LETTER_MAP[$char];
            $product = $value * $weight;
            $sum += intdiv($product, 10) + ($product % 10);
            $weight = $weight === 2 ? 1 : 2;
        }

        return (10 - ($sum % 10)) % 10;
    }

    public static function calculateS10CheckDigit(string $serial8): int
    {
        $sum = 0;
        for ($i = 0; $i < 8; $i++) {
            $sum += ((int) $serial8[$i]) * self::S10_WEIGHTS[$i];
        }

        $remainder = $sum % 11;

        if ($remainder === 0) {
            return 0;
        }

        if ($remainder === 1) {
            return 5;
        }

        return 11 - $remainder;
    }
}
