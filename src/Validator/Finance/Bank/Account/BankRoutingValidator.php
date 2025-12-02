<?php

namespace TextProbe\Validator\Finance\Bank\Account;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for US bank routing (ABA) numbers.
 *
 * This validator:
 * - strips all non-digit characters from the input,
 * - ensures the result is exactly 9 digits long,
 * - verifies the official ABA checksum using weighted sums of the digits.
 */
class BankRoutingValidator implements IValidator
{
    /**
     * Validates a raw routing number string.
     *
     * The algorithm:
     * - normalizes input by removing non-digits,
     * - checks length equals 9,
     * - applies the checksum:
     *   (d1 + d4 + d7) * 3 +
     *   (d2 + d5 + d8) * 7 +
     *   (d3 + d6 + d9) * 1
     *   and verifies that the result is divisible by 10.
     *
     * @param string $raw Raw routing number as found in text (may contain spaces, dashes, etc.).
     *
     * @return bool true if the routing number is 9 digits and passes the checksum, false otherwise
     */
    public function validate(string $raw): bool
    {
        $number = preg_replace('/\D/', '', $raw);

        if (!isset($number) || strlen($number) !== 9) {
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
