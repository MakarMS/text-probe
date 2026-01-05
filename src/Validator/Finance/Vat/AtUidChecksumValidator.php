<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for AtUidChecksumValidator.
 */
class AtUidChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = substr($raw, 3);

        if (preg_match('/^\d{8}$/', $value) !== 1) {
            return false;
        }

        if (strlen($value) !== 8) {
            return false;
        }

        $weights = [1, 2, 1, 2, 1, 2, 1];
        $sum = 0;
        for ($i = 0; $i < 7; $i++) {
            $product = ((int) $value[$i]) * $weights[$i];
            $sum += intdiv($product, 10) + ($product % 10);
        }
        $sum += 4;
        $check = (10 - ($sum % 10)) % 10;

        return $check === (int) $value[7];
    }
}
