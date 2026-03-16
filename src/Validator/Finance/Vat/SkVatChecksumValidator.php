<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Validator for SkVatChecksumValidator.
 */
class SkVatChecksumValidator implements IValidator
{
    #[Override]
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{10}$/', $value) !== 1) {
            return false;
        }

        return ((int) $value) % 11 === 0;
    }
}
