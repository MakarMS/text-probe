<?php

namespace TextProbe\Validator\Text;

use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Validates ISBN-10 values using Mod-11 checksum.
 */
class Isbn10ChecksumValidator implements IValidator
{
    #[Override]
    public function validate(string $raw): bool
    {
        $normalized = strtoupper((string) preg_replace('/[^0-9X]/i', '', $raw));

        if (strlen($normalized) !== 10 || preg_match('/^\d{9}[\dX]$/', $normalized) !== 1) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += ((int) $normalized[$i]) * (10 - $i);
        }

        $check = $normalized[9] === 'X' ? 10 : (int) $normalized[9];
        $sum += $check;

        return $sum % 11 === 0;
    }
}
