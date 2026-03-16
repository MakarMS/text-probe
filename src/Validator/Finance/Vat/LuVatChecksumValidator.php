<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Validator for LuVatChecksumValidator.
 */
class LuVatChecksumValidator implements IValidator
{
    #[Override]
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^\d{8}$/', $value) !== 1) {
            return false;
        }

        return ((int) $value) % 89 === 0;
    }
}
