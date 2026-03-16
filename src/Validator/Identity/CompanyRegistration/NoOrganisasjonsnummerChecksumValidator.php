<?php

namespace TextProbe\Validator\Identity\CompanyRegistration;

use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Validator for Norwegian organisation numbers.
 */
class NoOrganisasjonsnummerChecksumValidator implements IValidator
{
    #[Override]
    public function validate(string $raw): bool
    {
        if (preg_match('/^\d{9}$/', $raw) !== 1) {
            return false;
        }

        $weights = [3, 2, 7, 6, 5, 4, 3, 2];
        $sum = 0;

        foreach ($weights as $index => $weight) {
            $sum += ((int) $raw[$index]) * $weight;
        }

        $mod = $sum % 11;

        if ($mod === 0) {
            $check = 0;
        } elseif ($mod === 1) {
            return false;
        } else {
            $check = 11 - $mod;
        }

        return $check === (int) $raw[8];
    }
}
