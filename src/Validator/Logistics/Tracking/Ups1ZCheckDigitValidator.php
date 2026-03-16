<?php

namespace TextProbe\Validator\Logistics\Tracking;

use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Validates UPS 1Z tracking numbers using the UPS mod10 check digit scheme.
 */
class Ups1ZCheckDigitValidator implements IValidator
{
    private const LETTER_MAP = [
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

    #[Override]
    public function validate(string $raw): bool
    {
        $raw = strtoupper($raw);

        if (preg_match('/^1Z[0-9A-Z]{16}$/', $raw) !== 1) {
            return false;
        }

        $checkChar = substr($raw, -1);

        if (!ctype_digit($checkChar)) {
            return false;
        }

        $body = substr($raw, 0, -1);
        $sum = 0;
        $weight = 2;

        for ($i = strlen($body) - 1; $i >= 0; $i--) {
            $char = $body[$i];
            $value = ctype_digit($char) ? (int) $char : (self::LETTER_MAP[$char] ?? null);

            if ($value === null) {
                return false;
            }

            $product = $value * $weight;
            $sum += intdiv($product, 10) + ($product % 10);

            $weight = $weight === 2 ? 1 : 2;
        }

        $expected = (10 - ($sum % 10)) % 10;

        return $expected === (int) $checkChar;
    }
}
