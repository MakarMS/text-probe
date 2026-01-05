<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for LtVatChecksumValidator.
 */
class LtVatChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^(\d{9}|\d{12})$/', $value) !== 1) {
            return false;
        }

        $len = strlen($value);

        if ($len === 9) {
            $sum = 0;
            for ($i = 0; $i < 8; $i++) {
                $sum += ((int) $value[$i]) * ($i + 1);
            }
            $mod = $sum % 11;

            if ($mod === 10) {
                $sum = 0;
                for ($i = 0; $i < 8; $i++) {
                    $sum += ((int) $value[$i]) * ($i + 3);
                }
                $mod = $sum % 11;

                if ($mod === 10) {
                    $mod = 0;
                }
            }

            return $mod === (int) $value[8];
        }

        $sum = 0;
        for ($i = 0; $i < 11; $i++) {
            $sum += ((int) $value[$i]) * ($i + 1);
        }
        $mod = $sum % 11;

        if ($mod === 10) {
            $sum = 0;
            for ($i = 0; $i < 11; $i++) {
                $sum += ((int) $value[$i]) * ($i + 3);
            }
            $mod = $sum % 11;

            if ($mod === 10) {
                $mod = 0;
            }
        }

        return $mod === (int) $value[11];
    }
}
