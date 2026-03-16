<?php

namespace TextProbe\Validator\Identity;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validates IMEI values with the Luhn checksum algorithm.
 */
class ImeiLuhnValidator implements IValidator
{
    #[\Override]
    public function validate(string $raw): bool
    {
        $digits = preg_replace('/\D+/', '', $raw);

        if (!isset($digits) || strlen($digits) !== 15) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 15; $i++) {
            $digit = (int) $digits[$i];

            if ($i % 2 === 1) {
                $digit *= 2;

                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
        }

        return $sum % 10 === 0;
    }
}
