<?php

namespace TextProbe\Validator\Identity\TaxNumber;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for Polish NIP numbers.
 */
class PlNipChecksumValidator implements IValidator
{
    #[\Override]
    public function validate(string $raw): bool
    {
        if (preg_match('/^\d{10}$/', $raw) !== 1) {
            return false;
        }

        $weights = [6, 5, 7, 2, 3, 4, 5, 6, 7];
        $sum = 0;

        foreach ($weights as $index => $weight) {
            $sum += ((int) $raw[$index]) * $weight;
        }

        $check = $sum % 11;

        return $check !== 10 && $check === (int) $raw[9];
    }
}
