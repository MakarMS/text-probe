<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for FiVatChecksumValidator.
 */
class FiVatChecksumValidator implements IValidator
{
    #[\Override]
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{8}$/', $value) !== 1) {
            return false;
        }

        $weights = [7, 9, 10, 5, 8, 4, 2];
        $sum = 0;
        for ($i = 0; $i < 7; $i++) {
            $sum += ((int) $value[$i]) * $weights[$i];
        }
        $check = 11 - ($sum % 11);

        if ($check === 10) {
            return false;
        }

        if ($check === 11) {
            $check = 0;
        }

        return $check === (int) $value[7];
    }
}
