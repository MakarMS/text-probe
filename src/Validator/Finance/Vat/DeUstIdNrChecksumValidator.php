<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for DeUstIdNrChecksumValidator.
 */
class DeUstIdNrChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{9}$/', $value) !== 1) {
            return false;
        }

        $product = 10;
        for ($i = 0; $i < 8; $i++) {
            $sum = ((int) $value[$i] + $product) % 10;

            if ($sum === 0) {
                $sum = 10;
            }
            $product = (2 * $sum) % 11;
        }
        $check = (11 - $product) % 10;

        return $check === (int) $value[8];
    }
}
