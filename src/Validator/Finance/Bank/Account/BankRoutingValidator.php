<?php

namespace TextProbe\Validator\Finance\Bank\Account;

use TextProbe\Validator\Contracts\IValidator;

class BankRoutingValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $number = preg_replace('/\D/', '', $raw);
        if (strlen($number) !== 9) {
            return false;
        }

        $sum = (
            (intval($number[0]) + intval($number[3]) + intval($number[6])) * 3 +
            (intval($number[1]) + intval($number[4]) + intval($number[7])) * 7 +
            intval($number[2]) + intval($number[5]) + intval($number[8])
        );

        return $sum % 10 === 0;
    }
}
