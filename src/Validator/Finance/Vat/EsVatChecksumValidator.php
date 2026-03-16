<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Validator for EsVatChecksumValidator.
 */
class EsVatChecksumValidator implements IValidator
{
    #[Override]
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^[A-Z0-9]\d{7}[A-Z0-9]$/', $value) !== 1) {
            return false;
        }

        $first = $value[0];
        $last = $value[8];
        $digits = substr($value, 1, 7);

        $nifLetters = 'TRWAGMYFPDXBNJZSQVHLCKE';

        if (ctype_digit($first)) {
            $number = (int) substr($value, 0, 8);
            $letter = $nifLetters[$number % 23];

            return $last === $letter;
        }

        if (in_array($first, ['X', 'Y', 'Z'], true)) {
            $prefix = ['X' => '0', 'Y' => '1', 'Z' => '2'][$first];
            $number = (int) ($prefix . $digits);
            $letter = $nifLetters[$number % 23];

            return $last === $letter;
        }

        $controlLetters = 'JABCDEFGHI';
        $sumEven = 0;
        $sumOdd = 0;
        for ($i = 0; $i < 7; $i++) {
            $digit = (int) $digits[$i];

            if ($i % 2 === 0) {
                $double = $digit * 2;
                $sumOdd += intdiv($double, 10) + ($double % 10);
            } else {
                $sumEven += $digit;
            }
        }
        $total = $sumEven + $sumOdd;
        $controlDigit = (10 - ($total % 10)) % 10;
        $controlLetter = $controlLetters[$controlDigit];

        if (ctype_digit($last)) {
            return $controlDigit === (int) $last;
        }

        return $last === $controlLetter;
    }
}
