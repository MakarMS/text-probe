<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for BgVatChecksumValidator.
 */
class BgVatChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{9,10}$/', $value) !== 1) {
            return false;
        }

        $len = strlen($value);

        if ($len !== 9 && $len !== 10) {
            return false;
        }

        if ($len === 9) {
            $weights = [1, 2, 3, 4, 5, 6, 7, 8];
            $sum = 0;
            for ($i = 0; $i < 8; $i++) {
                $sum += ((int) $value[$i]) * $weights[$i];
            }
            $mod = $sum % 11;

            if ($mod < 10 && $mod === (int) $value[8]) {
                return true;
            }

            $weights = [3, 4, 5, 6, 7, 8, 9, 10];
            $sum = 0;
            for ($i = 0; $i < 8; $i++) {
                $sum += ((int) $value[$i]) * $weights[$i];
            }
            $mod = $sum % 11;

            return $mod < 10 && $mod === (int) $value[8];
        }

        $weights = [2, 4, 8, 5, 10, 9, 7, 3, 6];
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += ((int) $value[$i]) * $weights[$i];
        }
        $mod = $sum % 11;

        if ($mod === 10) {
            $mod = 0;
        }

        return $mod === (int) $value[9];
    }
}
