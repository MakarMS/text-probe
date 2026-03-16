<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for LvVatChecksumValidator.
 */
class LvVatChecksumValidator implements IValidator
{
    #[\Override]
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{11}$/', $value) !== 1) {
            return false;
        }

        $weights = [9, 1, 4, 8, 3, 10, 2, 5, 7, 6];
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += ((int) $value[$i]) * $weights[$i];
        }
        $mod = $sum % 11;

        if ($mod === 10) {
            $mod = 0;
        }

        return $mod === (int) $value[10];
    }
}
