<?php

namespace TextProbe\Validator\Finance\Bank\Card;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for generic bank card numbers.
 *
 * This validator:
 * - strips all non-digit characters from the input,
 * - checks that the numeric length is between 13 and 19 digits (inclusive),
 * - performs a Luhn checksum verification to reduce false positives.
 */
class BankCardNumberValidator implements IValidator
{
    /**
     * Validates a raw card number string.
     *
     * The method:
     * - normalizes the input by removing any non-digit characters,
     * - rejects empty or out-of-range lengths,
     * - applies the Luhn algorithm to verify the final checksum.
     *
     * @param string $raw Raw card number as found in text (may contain spaces, dashes, etc.).
     *
     * @return bool true if the card number is of valid length and passes the Luhn check,
     *              false otherwise
     */
    public function validate(string $raw): bool
    {
        $normalized = preg_replace('/\D+/', '', $raw);

        if (!isset($normalized)) {
            return false;
        }

        $len = strlen($normalized);

        if ($len < 13 || $len > 19) {
            return false;
        }

        return $this->luhnCheck($normalized);
    }

    /**
     * Runs the Luhn (mod 10) checksum for a numeric card string.
     *
     * Digits are processed from left to right; every second digit (depending on
     * overall length parity) is doubled, and if the result is greater than 9,
     * 9 is subtracted. The sum of all processed digits must be divisible by 10
     * for the number to be considered valid.
     *
     * @param string $number normalized card number containing only digits
     *
     * @return bool true if the Luhn checksum passes, false otherwise
     */
    private function luhnCheck(string $number): bool
    {
        $sum = 0;
        $len = strlen($number);
        $parity = $len % 2;

        for ($i = 0; $i < $len; $i++) {
            $digit = (int) $number[$i];

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
