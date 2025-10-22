<?php

namespace TextProbe\Validator\Finance\Bank\Card;

use TextProbe\Validator\Contracts\IValidator;

class BankCardNumberValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $normalized = preg_replace('/\D+/', '', $raw);

        if (empty($normalized)) {
            return false;
        }

        $len = strlen($normalized);

        if ($len < 13 || $len > 19) {
            return false;
        }

        return $this->luhnCheck($normalized);
    }

    private function luhnCheck(string $number): bool
    {
        $sum = 0;
        $len = strlen($number);
        $parity = $len % 2;

        for ($i = 0; $i < $len; $i++) {
            $digit = (int)$number[$i];
            if ($i % 2 === $parity) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            $sum += $digit;
        }

        return $sum % 10 === 0;
    }
}