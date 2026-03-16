<?php

namespace TextProbe\Validator\Identity\TaxNumber;

use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Validator for Spanish NIF (DNI/NIE).
 */
class EsNifControlValidator implements IValidator
{
    private const DNI_LETTERS = 'TRWAGMYFPDXBNJZSQVHLCKE';

    #[Override]
    public function validate(string $raw): bool
    {
        if (preg_match('/^[A-Z0-9]\d{7}[A-Z0-9]$/', $raw) !== 1) {
            return false;
        }

        $raw = strtoupper($raw);
        $first = $raw[0];
        $last = $raw[8];

        if (!ctype_alpha($last)) {
            return false;
        }

        if (ctype_digit($first)) {
            $number = (int) substr($raw, 0, 8);
        } elseif (in_array($first, ['X', 'Y', 'Z'], true)) {
            $prefix = ['X' => '0', 'Y' => '1', 'Z' => '2'][$first];
            $number = (int) ($prefix . substr($raw, 1, 7));
        } else {
            return false;
        }

        $expected = self::DNI_LETTERS[$number % 23];

        return $expected === $last;
    }
}
