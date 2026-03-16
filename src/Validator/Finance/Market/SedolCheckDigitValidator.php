<?php

namespace TextProbe\Validator\Finance\Market;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validates SEDOL values using weighted Mod-10 checksum.
 */
class SedolCheckDigitValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = strtoupper(trim($raw));

        if (preg_match('/^[0-9BCDFGHJKLMNPQRSTVWXYZ]{6}[0-9]$/', $value) !== 1) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 6; $i++) {
            $weight = $this->weightByIndex($i);
            if ($weight === 0) {
                return false;
            }

            $sum += $this->charValue($value[$i]) * $weight;
        }

        $check = (10 - ($sum % 10)) % 10;

        return $check === (int) $value[6];
    }

    private function charValue(string $char): int
    {
        if (ctype_digit($char)) {
            return (int) $char;
        }

        return ord($char) - 55;
    }

    private function weightByIndex(int $index): int
    {
        return match ($index) {
            0 => 1,
            1 => 3,
            2 => 1,
            3 => 7,
            4 => 3,
            5 => 9,
            default => 0,
        };
    }
}
