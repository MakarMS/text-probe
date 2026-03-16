<?php

namespace TextProbe\Validator\Text;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validates ISBN-13 values using EAN-13 checksum.
 */
class Isbn13ChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $digits = preg_replace('/\D+/', '', $raw);

        if (!isset($digits) || strlen($digits) !== 13 || !str_starts_with($digits, '978') && !str_starts_with($digits, '979')) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $digit = (int) $digits[$i];
            $sum += ($i % 2 === 0) ? $digit : $digit * 3;
        }

        $check = (10 - ($sum % 10)) % 10;

        return $check === (int) $digits[12];
    }
}
