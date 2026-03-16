<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for GbVatChecksumValidator.
 */
class GbVatChecksumValidator implements IValidator
{
    #[\Override]
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{9}$/', $value) !== 1) {
            return false;
        }

        $weights = [8, 7, 6, 5, 4, 3, 2];
        $sum = 0;
        for ($i = 0; $i < 7; $i++) {
            $sum += ((int) $value[$i]) * $weights[$i];
        }
        $check = 97 - ($sum % 97);

        return (int) substr($value, 7, 2) === $check;
    }
}
