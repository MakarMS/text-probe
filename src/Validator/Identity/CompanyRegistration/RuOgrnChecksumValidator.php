<?php

namespace TextProbe\Validator\Identity\CompanyRegistration;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for Russian OGRN numbers.
 */
class RuOgrnChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        if (preg_match('/^\d{13}$/', $raw) !== 1) {
            return false;
        }

        $base = substr($raw, 0, 12);
        $check = ((int) $base % 11) % 10;

        return $check === (int) $raw[12];
    }
}
