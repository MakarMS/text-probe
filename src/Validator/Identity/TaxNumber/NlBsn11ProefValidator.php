<?php

namespace TextProbe\Validator\Identity\TaxNumber;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for Dutch BSN (11-proef).
 */
class NlBsn11ProefValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        if (preg_match('/^\d{9}$/', $raw) !== 1) {
            return false;
        }

        $weights = [9, 8, 7, 6, 5, 4, 3, 2, -1];
        $sum = 0;

        foreach ($weights as $index => $weight) {
            $sum += ((int) $raw[$index]) * $weight;
        }

        return $sum % 11 === 0;
    }
}
