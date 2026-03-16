<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for EeKmkrChecksumValidator.
 */
class EeKmkrChecksumValidator implements IValidator
{
    #[\Override]
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{9}$/', $value) !== 1) {
            return false;
        }

        $weights = [3, 7, 1, 3, 7, 1, 3, 7];
        $sum = 0;
        for ($i = 0; $i < 8; $i++) {
            $sum += ((int) $value[$i]) * $weights[$i];
        }
        $check = (10 - ($sum % 10)) % 10;

        return $check === (int) $value[8];
    }
}
