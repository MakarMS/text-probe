<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Validator for Swedish VAT numbers.
 */
class SeVatChecksumValidator implements IValidator
{
    #[Override]
    public function validate(string $raw): bool
    {
        if (preg_match('/^SE(?<digits>\d{12})$/', $raw, $matches) !== 1) {
            return false;
        }

        $digits = $matches['digits'];
        $orgNumber = substr($digits, 0, 10);
        $suffix = substr($digits, 10, 2);

        if ($suffix !== '01') {
            return false;
        }

        return VatChecksumHelper::luhn($orgNumber);
    }
}
