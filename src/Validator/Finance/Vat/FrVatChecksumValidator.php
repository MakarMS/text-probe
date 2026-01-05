<?php

namespace TextProbe\Validator\Finance\Vat;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for FrVatChecksumValidator.
 */
class FrVatChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = substr($raw, 2);

        if (preg_match('/^[A-Z0-9]{2}\d{9}$/', $value) !== 1) {
            return false;
        }

        $key = substr($value, 0, 2);
        $siren = (int) substr($value, 2);

        if (ctype_digit($key)) {
            $check = (12 + 3 * ($siren % 97)) % 97;

            return (int) $key === $check;
        }

        $keyValue = '';
        for ($i = 0; $i < 2; $i++) {
            $char = $key[$i];

            if ($char >= 'A' && $char <= 'Z') {
                $keyValue .= (string) (ord($char) - 55);
            } else {
                $keyValue .= $char;
            }
        }
        $keyNum = (int) $keyValue;

        return ($keyNum + $siren) % 97 === 0;
    }
}
