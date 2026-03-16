<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Validator for DkCvrChecksumValidator.
 */
class DkCvrChecksumValidator implements IValidator
{
    #[Override]
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{8}$/', $value) !== 1) {
            return false;
        }

        $weights = [2, 7, 6, 5, 4, 3, 2, 1];
        $sum = 0;
        for ($i = 0; $i < 8; $i++) {
            $sum += ((int) $value[$i]) * $weights[$i];
        }

        return $sum % 11 === 0;
    }
}
