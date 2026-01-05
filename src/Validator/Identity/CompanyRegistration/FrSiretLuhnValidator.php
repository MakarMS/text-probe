<?php

namespace TextProbe\Validator\Identity\CompanyRegistration;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for French SIRET numbers.
 */
class FrSiretLuhnValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        if (preg_match('/^\d{14}$/', $raw) !== 1) {
            return false;
        }

        return $this->luhn($raw);
    }

    private function luhn(string $digits): bool
    {
        $sum = 0;
        $alt = false;

        for ($i = strlen($digits) - 1; $i >= 0; $i--) {
            $digit = (int) $digits[$i];

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
