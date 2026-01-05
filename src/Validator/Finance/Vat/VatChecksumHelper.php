<?php

namespace TextProbe\Validator\Finance\Vat;

class VatChecksumHelper
{
    /**
     * @return int[]
     */
    public static function digits(string $value): array
    {
        return array_map('intval', str_split($value));
    }

    public static function luhn(string $value): bool
    {
        $sum = 0;
        $alt = false;
        for ($i = strlen($value) - 1; $i >= 0; $i--) {
            $digit = (int) $value[$i];

            if ($alt) {
                $digit *= 2;

                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            $sum += $digit;
            $alt = !$alt;
        }

        return $sum % 10 === 0;
    }
}
