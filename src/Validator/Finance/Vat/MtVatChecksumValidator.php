<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for MtVatChecksumValidator.
 */
class MtVatChecksumValidator implements IValidator
{
    #[\Override]
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{8}$/', $value) !== 1) {
            return false;
        }

        $weights = [3, 4, 6, 7, 8, 9];
        $sum = 0;
        for ($i = 0; $i < 6; $i++) {
            $sum += ((int) $value[$i]) * $weights[$i];
        }
        $check = 37 - ($sum % 37);

        if ($check === 37) {
            $check = 0;
        }

        return (int) substr($value, 6, 2) === $check;
    }
}
