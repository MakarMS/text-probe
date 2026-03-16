<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Validator for RoVatChecksumValidator.
 */
class RoVatChecksumValidator implements IValidator
{
    #[Override]
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{2,10}$/', $value) !== 1) {
            return false;
        }

        $weights = '753217532';
        $digits = str_pad($value, 10, '0', STR_PAD_LEFT);
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += ((int) $digits[$i]) * (int) $weights[$i];
        }
        $check = ($sum * 10) % 11;

        if ($check === 10) {
            $check = 0;
        }

        return $check === (int) $digits[9];
    }
}
