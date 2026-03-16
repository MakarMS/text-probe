<?php

namespace TextProbe\Validator\Identity\MedicalPolicy;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for UK NHS numbers.
 */
class GbNhsChecksumValidator implements IValidator
{
    #[\Override]
    public function validate(string $raw): bool
    {
        if (trim($raw) !== $raw) {
            return false;
        }

        $digits = preg_replace('/\s+/', '', $raw);

        if ($digits === null || preg_match('/^\d{10}$/', $digits) !== 1) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += ((int) $digits[$i]) * (10 - $i);
        }

        $check = 11 - ($sum % 11);

        if ($check === 11) {
            $check = 0;
        }

        if ($check === 10) {
            return false;
        }

        return $check === (int) $digits[9];
    }
}
