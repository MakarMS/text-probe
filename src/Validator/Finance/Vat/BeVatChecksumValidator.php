<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for BeVatChecksumValidator.
 */
class BeVatChecksumValidator implements IValidator
{
    #[\Override]
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^0?\d{9}$/', $value) !== 1) {
            return false;
        }

        $digits = str_pad($value, 10, '0', STR_PAD_LEFT);
        $base = (int) substr($digits, 0, 8);
        $check = 97 - ($base % 97);

        return (int) substr($digits, 8, 2) === $check;
    }
}
