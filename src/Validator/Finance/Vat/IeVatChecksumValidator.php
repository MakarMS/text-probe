<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for IeVatChecksumValidator.
 */
class IeVatChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^(\d{7}[A-Z]{1,2}|\d[A-Z]\d{5}[A-Z])$/', $value) !== 1) {
            return false;
        }

        $letters = 'WABCDEFGHIJKLMNOPQRSTUV';

        if (preg_match('/^\d{7}[A-Z]{1,2}$/', $value) === 1) {
            $digits = substr($value, 0, 7);
            $sum = 0;
            $weights = [8, 7, 6, 5, 4, 3, 2];
            for ($i = 0; $i < 7; $i++) {
                $sum += ((int) $digits[$i]) * $weights[$i];
            }
            $check = $letters[$sum % 23];

            return $check === $value[7];
        }

        $digits = $value[0] . substr($value, 2, 5);
        $sum = 0;
        $weights = [8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 7; $i++) {
            $sum += ((int) $digits[$i]) * $weights[$i];
        }
        $check = $letters[$sum % 23];

        return $check === $value[7];
    }
}
