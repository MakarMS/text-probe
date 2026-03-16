<?php

namespace TextProbe\Validator\Barcode;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validates GTIN-14 values using Mod-10 checksum.
 */
class Gtin14ChecksumValidator implements IValidator
{
    #[\Override]
    public function validate(string $raw): bool
    {
        $digits = preg_replace('/\D+/', '', $raw);

        if (!isset($digits) || strlen($digits) !== 14) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 13; $i++) {
            $digit = (int) $digits[$i];
            $weight = (($i + 1) % 2 === 0) ? 1 : 3;
            $sum += $digit * $weight;
        }

        $check = (10 - ($sum % 10)) % 10;

        return $check === (int) $digits[13];
    }
}
