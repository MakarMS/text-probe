<?php

namespace TextProbe\Validator\Finance\Market;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validates ISIN values using the ISO 6166 checksum algorithm.
 */
class IsinChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = strtoupper(trim($raw));

        if (preg_match('/^[A-Z]{2}[A-Z0-9]{9}\d$/', $value) !== 1) {
            return false;
        }

        $expanded = '';
        foreach (str_split($value) as $char) {
            if (ctype_alpha($char)) {
                $expanded .= (string) (ord($char) - 55);
                continue;
            }

            $expanded .= $char;
        }

        return $this->luhn($expanded);
    }

    private function luhn(string $value): bool
    {
        $sum = 0;
        $alternate = false;

        for ($i = strlen($value) - 1; $i >= 0; $i--) {
            $digit = (int) $value[$i];

            if ($alternate) {
                $digit *= 2;

                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
            $alternate = !$alternate;
        }

        return $sum % 10 === 0;
    }
}
