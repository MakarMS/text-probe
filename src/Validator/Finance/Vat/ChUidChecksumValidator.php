<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Validator for ChUidChecksumValidator.
 */
class ChUidChecksumValidator implements IValidator
{
    #[Override]
    public function validate(string $raw): bool
    {
        $value = substr($raw, 3, 9);

        if (preg_match('/^\d{9}$/', $value) !== 1) {
            return false;
        }

        $weights = [5, 4, 3, 2, 7, 6, 5, 4];
        $sum = 0;
        for ($i = 0; $i < 8; $i++) {
            $sum += ((int) $value[$i]) * $weights[$i];
        }
        $check = 11 - ($sum % 11);

        if ($check === 10) {
            return false;
        }

        if ($check === 11) {
            $check = 0;
        }

        return $check === (int) $value[8];
    }
}
