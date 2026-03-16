<?php

namespace TextProbe\Validator\Finance\Market;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validates LEI values according to ISO 17442 (mod-97-10).
 */
class LeiChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = strtoupper(trim($raw));

        if (preg_match('/^[A-Z0-9]{18}\d{2}$/', $value) !== 1) {
            return false;
        }

        $rearranged = substr($value, 4) . substr($value, 0, 4);
        $numeric = '';

        foreach (str_split($rearranged) as $char) {
            if (ctype_alpha($char)) {
                $numeric .= (string) (ord($char) - 55);
                continue;
            }

            $numeric .= $char;
        }

        return $this->mod97($numeric) === 1;
    }

    private function mod97(string $digits): int
    {
        $remainder = 0;
        $length = strlen($digits);

        for ($i = 0; $i < $length; $i++) {
            $remainder = ($remainder * 10 + (int) $digits[$i]) % 97;
        }

        return $remainder;
    }
}
