<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for GrAfmChecksumValidator.
 */
class GrAfmChecksumValidator implements IValidator
{
    #[\Override]
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{9}$/', $value) !== 1) {
            return false;
        }

        $weights = [256, 128, 64, 32, 16, 8, 4, 2];
        $sum = 0;
        for ($i = 0; $i < 8; $i++) {
            $sum += ((int) $value[$i]) * $weights[$i];
        }
        $check = ($sum % 11) % 10;

        return $check === (int) $value[8];
    }
}
