<?php

namespace TextProbe\Validator\Identity\TaxNumber;

use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Validator for German tax identification numbers (Steuer-ID).
 */
class DeSteuerIdChecksumValidator implements IValidator
{
    #[Override]
    public function validate(string $raw): bool
    {
        if (preg_match('/^\d{11}$/', $raw) !== 1) {
            return false;
        }

        $product = 10;

        for ($i = 0; $i < 10; $i++) {
            $sum = (((int) $raw[$i]) + $product) % 10;

            if ($sum === 0) {
                $sum = 10;
            }
            $product = (2 * $sum) % 11;
        }

        $check = 11 - $product;

        if ($check === 10 || $check === 11) {
            $check = 0;
        }

        return $check === (int) $raw[10];
    }
}
