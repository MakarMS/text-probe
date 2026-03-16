<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for CzDicChecksumValidator.
 */
class CzDicChecksumValidator implements IValidator
{
    #[\Override]
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{8,10}$/', $value) !== 1) {
            return false;
        }

        $len = strlen($value);

        if ($len === 8) {
            $weights = [8, 7, 6, 5, 4, 3, 2];
            $sum = 0;
            for ($i = 0; $i < 7; $i++) {
                $sum += ((int) $value[$i]) * $weights[$i];
            }
            $mod = $sum % 11;
            $check = 11 - $mod;

            if ($check === 10) {
                $check = 0;
            } elseif ($check === 11) {
                $check = 1;
            }

            return $check === (int) $value[7];
        }

        $sum = 0;
        for ($i = 0; $i < $len - 1; $i++) {
            $weight = ($len - 1) - $i;
            $sum += ((int) $value[$i]) * $weight;
        }
        $mod = $sum % 11;
        $check = 11 - $mod;

        if ($check === 10) {
            $check = 0;
        } elseif ($check === 11) {
            $check = 1;
        }

        return $check === (int) $value[$len - 1];
    }
}
