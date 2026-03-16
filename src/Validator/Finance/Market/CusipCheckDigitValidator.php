<?php

namespace TextProbe\Validator\Finance\Market;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validates CUSIP values using the official check digit algorithm.
 */
class CusipCheckDigitValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = strtoupper(trim($raw));

        if (preg_match('/^[0-9A-Z*@#]{8}[0-9]$/', $value) !== 1) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 8; $i++) {
            $digit = $this->charValue($value[$i]);
            if ($digit < 0) {
                return false;
            }

            if (($i + 1) % 2 === 0) {
                $digit *= 2;
            }

            $sum += intdiv($digit, 10) + ($digit % 10);
        }

        $check = (10 - ($sum % 10)) % 10;

        return $check === (int) $value[8];
    }

    private function charValue(string $char): int
    {
        if (ctype_digit($char)) {
            return (int) $char;
        }

        if ($char >= 'A' && $char <= 'Z') {
            return ord($char) - 55;
        }

        return match ($char) {
            '*' => 36,
            '@' => 37,
            '#' => 38,
            default => -1,
        };
    }
}
