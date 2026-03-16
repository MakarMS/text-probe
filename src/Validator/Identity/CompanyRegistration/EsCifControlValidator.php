<?php

namespace TextProbe\Validator\Identity\CompanyRegistration;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for Spanish CIF numbers.
 */
class EsCifControlValidator implements IValidator
{
    private const CONTROL_LETTERS = 'JABCDEFGHI';

    #[\Override]

    public function validate(string $raw): bool
    {
        if (preg_match('/^[A-Z]\d{7}[A-Z0-9]$/', $raw) !== 1) {
            return false;
        }

        $digits = substr($raw, 1, 7);
        $control = $raw[8];

        $evenSum = 0;
        $oddSum = 0;

        for ($i = 0; $i < 7; $i++) {
            $digit = (int) $digits[$i];

            if ($i % 2 === 1) {
                $evenSum += $digit;
            } else {
                $value = $digit * 2;
                $oddSum += intdiv($value, 10) + ($value % 10);
            }
        }

        $total = $evenSum + $oddSum;
        $controlNum = (10 - ($total % 10)) % 10;
        $controlLetter = self::CONTROL_LETTERS[$controlNum];

        if (ctype_digit($control)) {
            return $controlNum === (int) $control;
        }

        return $controlLetter === $control;
    }
}
