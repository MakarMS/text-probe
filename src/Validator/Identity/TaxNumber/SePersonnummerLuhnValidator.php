<?php

namespace TextProbe\Validator\Identity\TaxNumber;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for Swedish personal identity numbers (personnummer).
 */
class SePersonnummerLuhnValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        if (preg_match('/^(?:\d{6}|\d{8})[-+]?\d{4}$/', $raw) !== 1) {
            return false;
        }

        $digits = preg_replace('/\D+/', '', $raw);

        if ($digits === null || !in_array(strlen($digits), [10, 12], true)) {
            return false;
        }

        if (strlen($digits) === 12) {
            $digits = substr($digits, 2);
        }

        return $this->luhn($digits);
    }

    private function luhn(string $digits): bool
    {
        $sum = 0;
        $alt = false;

        for ($i = strlen($digits) - 1; $i >= 0; $i--) {
            $digit = (int) $digits[$i];

            if ($alt) {
                $digit *= 2;

                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            $sum += $digit;
            $alt = !$alt;
        }

        return $sum % 10 === 0;
    }
}
