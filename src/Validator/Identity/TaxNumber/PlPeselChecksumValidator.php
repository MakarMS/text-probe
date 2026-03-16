<?php

namespace TextProbe\Validator\Identity\TaxNumber;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for Polish PESEL numbers.
 */
class PlPeselChecksumValidator implements IValidator
{
    #[\Override]
    public function validate(string $raw): bool
    {
        if (preg_match('/^\d{11}$/', $raw) !== 1) {
            return false;
        }

        $weights = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];
        $sum = 0;

        foreach ($weights as $index => $weight) {
            $sum += ((int) $raw[$index]) * $weight;
        }

        $check = (10 - ($sum % 10)) % 10;

        return $check === (int) $raw[10];
    }
}
