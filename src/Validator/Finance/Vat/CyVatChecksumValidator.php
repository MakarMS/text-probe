<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for CyVatChecksumValidator.
 */
class CyVatChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{8}[A-Z]$/', $value) !== 1) {
            return false;
        }

        $digits = substr($value, 0, 8);
        $map = [1, 0, 5, 7, 9, 13, 15, 17, 19, 21];
        $sum = 0;
        for ($i = 0; $i < 8; $i++) {
            if ($i % 2 === 0) {
                $digit = (int) $digits[$i];
                $mapped = $map[$digit] ?? null;

                if ($mapped === null) {
                    return false;
                }
                $sum += $mapped;
            } else {
                $sum += (int) $digits[$i];
            }
        }

        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $check = $letters[$sum % 26];

        return $check === $value[8];
    }
}
