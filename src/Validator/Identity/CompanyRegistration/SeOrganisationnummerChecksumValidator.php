<?php

namespace TextProbe\Validator\Identity\CompanyRegistration;

use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Validator for Swedish organisation numbers.
 */
class SeOrganisationnummerChecksumValidator implements IValidator
{
    #[Override]
    public function validate(string $raw): bool
    {
        if (preg_match('/^\d{6}-\d{4}$/', $raw) !== 1) {
            return false;
        }

        $digits = str_replace('-', '', $raw);

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
