<?php

namespace TextProbe\Validator\Finance\Reference;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for SEPA RF references using Mod-97.
 */
class Mod97Validator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = strtoupper($raw);

        if (preg_match('/^RF\d{2}[A-Z0-9]{1,21}$/', $value) !== 1) {
            return false;
        }

        $rearranged = substr($value, 4) . substr($value, 0, 4);

        $numeric = '';
        $length = strlen($rearranged);
        for ($i = 0; $i < $length; $i++) {
            $char = $rearranged[$i];

            if ($char >= 'A' && $char <= 'Z') {
                $numeric .= (string) (ord($char) - 55);
            } else {
                $numeric .= $char;
            }
        }

        $mod = 0;
        $numLength = strlen($numeric);
        for ($i = 0; $i < $numLength; $i++) {
            $mod = ($mod * 10 + (int) $numeric[$i]) % 97;
        }

        return $mod === 1;
    }
}
