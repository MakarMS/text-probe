<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for SiVatChecksumValidator.
 */
class SiVatChecksumValidator implements IValidator
{
    #[\Override]
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{8}$/', $value) !== 1) {
            return false;
        }

        $weights = [8, 7, 6, 5, 4, 3, 2];
        $sum = 0;
        for ($i = 0; $i < 7; $i++) {
            $sum += ((int) $value[$i]) * $weights[$i];
        }
        $check = 11 - ($sum % 11);

        if ($check === 10) {
            $check = 0;
        } elseif ($check === 11) {
            $check = 0;
        }

        return $check === (int) $value[7];
    }
}
