<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for XiVatChecksumValidator.
 */
class XiVatChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = 'GB' . substr($raw, 2);
        $validator = new GbVatChecksumValidator();

        return $validator->validate($value);
    }
}
