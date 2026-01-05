<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for HrOibChecksumValidator.
 */
class HrOibChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{11}$/', $value) !== 1) {
            return false;
        }

        $a = 10;
        for ($i = 0; $i < 10; $i++) {
            $a = ($a + (int) $value[$i]) % 10;

            if ($a === 0) {
                $a = 10;
            }
            $a = ($a * 2) % 11;
        }
        $check = 11 - $a;

        if ($check === 10) {
            $check = 0;
        }

        return $check === (int) $value[10];
    }
}
