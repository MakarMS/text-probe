<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for ItVatChecksumValidator.
 */
class ItVatChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{11}$/', $value) !== 1) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $digit = (int) $value[$i];

            if ($i % 2 === 0) {
                $sum += $digit;
            } else {
                $double = $digit * 2;

                if ($double > 9) {
                    $double -= 9;
                }
                $sum += $double;
            }
        }
        $check = (10 - ($sum % 10)) % 10;

        return $check === (int) $value[10];
    }
}
