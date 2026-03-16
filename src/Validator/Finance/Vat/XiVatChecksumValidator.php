<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Validator for XiVatChecksumValidator.
 */
class XiVatChecksumValidator implements IValidator
{
    #[Override]
    public function validate(string $raw): bool
    {
        $value = 'GB' . substr($raw, 2);
        $validator = new GbVatChecksumValidator();

        return $validator->validate($value);
    }
}
