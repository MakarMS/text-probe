<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Validator for Dutch VAT numbers.
 */
class NlVatChecksumValidator implements IValidator
{
    #[Override]
    public function validate(string $raw): bool
    {
        if (preg_match('/^NL(?<digits>\d{9})B(?<suffix>\d{2})$/', $raw, $matches) !== 1) {
            return false;
        }

        $digits = $matches['digits'];
        $suffix = (int) $matches['suffix'];

        if ($suffix % 2 !== 0) {
            return false;
        }
        $weights = [9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;

        for ($i = 0; $i < 8; $i++) {
            $sum += (int) $digits[$i] * $weights[$i];
        }

        $check = $sum % 11;

        if ($check === 10) {
            return false;
        }

        return $check === (int) $digits[8];
    }
}
