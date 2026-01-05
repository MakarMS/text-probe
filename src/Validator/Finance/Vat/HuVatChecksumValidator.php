<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for HuVatChecksumValidator.
 */
class HuVatChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{8}$/', $value) !== 1) {
            return false;
        }

        $weights = [9, 7, 3, 1, 9, 7, 3];
        $sum = 0;
        for ($i = 0; $i < 7; $i++) {
            $sum += ((int) $value[$i]) * $weights[$i];
        }
        $check = (10 - ($sum % 10)) % 10;

        return $check === (int) $value[7];
    }
}
