<?php

namespace TextProbe\Validator\Text;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validates ISSN values using Mod-11 checksum.
 */
class IssnChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $normalized = strtoupper((string) preg_replace('/[^0-9X]/i', '', $raw));

        if (strlen($normalized) !== 8 || preg_match('/^\d{7}[\dX]$/', $normalized) !== 1) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 7; $i++) {
            $sum += ((int) $normalized[$i]) * (8 - $i);
        }

        $remainder = $sum % 11;
        $check = (11 - $remainder) % 11;
        $expected = $check === 10 ? 'X' : (string) $check;

        return $normalized[7] === $expected;
    }
}
