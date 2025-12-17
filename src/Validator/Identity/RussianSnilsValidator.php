<?php

namespace TextProbe\Validator\Identity;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for Russian SNILS (11-digit personal insurance) numbers.
 *
 * Validation steps:
 * - strips all non-digit characters,
 * - checks that the result contains exactly 11 digits,
 * - rejects an all-zero number,
 * - verifies the checksum using the official weighted sum algorithm
 *   (weights 9..1 applied to the first nine digits).
 */
class RussianSnilsValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $normalized = preg_replace('/\D/', '', $raw);

        if (!isset($normalized) || strlen($normalized) !== 11) {
            return false;
        }

        if (substr($normalized, 0, 9) === '000000000') {
            return false;
        }

        $checksum = substr($normalized, -2);
        $sum = 0;

        for ($i = 0; $i < 9; $i++) {
            $sum += intval($normalized[$i]) * (9 - $i);
        }

        if ($sum < 100) {
            $expected = $sum;
        } elseif ($sum === 100 || $sum === 101) {
            $expected = 0;
        } else {
            $expected = $sum % 101;

            if ($expected === 100) {
                $expected = 0;
            }
        }

        return $checksum === str_pad((string) $expected, 2, '0', STR_PAD_LEFT);
    }
}
