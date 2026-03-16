<?php

namespace TextProbe\Validator\Identity\TaxNumber;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for Swiss AHV numbers.
 */
class ChAhvChecksumValidator implements IValidator
{
    #[\Override]
    public function validate(string $raw): bool
    {
        if (preg_match('/^756\.\d{4}\.\d{4}\.\d{2}$/', $raw) !== 1) {
            return false;
        }

        $digits = str_replace('.', '', $raw);

        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $weight = ($i % 2 === 0) ? 1 : 3;
            $sum += (int) $digits[$i] * $weight;
        }

        $check = (10 - ($sum % 10)) % 10;

        return $check === (int) $digits[12];
    }
}
