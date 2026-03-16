<?php

namespace TextProbe\Validator\Logistics\Tracking;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validates UPU S10 tracking numbers using the standard check digit rules.
 */
class UpuS10CheckDigitValidator implements IValidator
{
    private const WEIGHTS = [8, 6, 4, 2, 3, 5, 9, 7];

    #[\Override]

    public function validate(string $raw): bool
    {
        $raw = strtoupper($raw);

        if (preg_match('/^[A-Z]{2}\d{9}[A-Z]{2}$/', $raw) !== 1) {
            return false;
        }

        $digits = substr($raw, 2, 9);
        $serial = substr($digits, 0, 8);
        $checkDigit = (int) $digits[8];

        $sum = 0;
        for ($i = 0; $i < 8; $i++) {
            $sum += ((int) $serial[$i]) * self::WEIGHTS[$i];
        }

        $remainder = $sum % 11;

        if ($remainder === 0) {
            $expected = 0;
        } elseif ($remainder === 1) {
            $expected = 5;
        } else {
            $expected = 11 - $remainder;
        }

        return $checkDigit === $expected;
    }
}
