<?php

namespace TextProbe\Validator\Finance\Company;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for Russian Primary State Registration Numbers (OGRN).
 *
 * The validator:
 * - strips all non-digit characters from the input,
 * - ensures the normalized value is exactly 13 digits long,
 * - verifies the checksum: (first 12 digits mod 11) mod 10 must equal the 13th digit.
 */
class RussianOgrnNumberValidator implements IValidator
{
    /**
     * Validates a raw OGRN string.
     *
     * @param string $raw raw value as found in text
     */
    public function validate(string $raw): bool
    {
        $number = preg_replace('/\D/', '', $raw);

        if (!isset($number) || strlen($number) !== 13) {
            return false;
        }

        $body = substr($number, 0, 12);
        $checksum = intval(substr($number, -1));
        $calculated = (intval($body) % 11) % 10;

        return $checksum === $calculated;
    }
}
