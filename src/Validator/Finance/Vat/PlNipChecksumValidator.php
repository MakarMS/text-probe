<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for PlNipChecksumValidator.
 */
class PlNipChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{10}$/', $value) !== 1) {
            return false;
        }

        $weights = [6, 5, 7, 2, 3, 4, 5, 6, 7];
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += ((int) $value[$i]) * $weights[$i];
        }
        $mod = $sum % 11;

        if ($mod === 10) {
            return false;
        }

        return $mod === (int) $value[9];
    }
}
