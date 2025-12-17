<?php

namespace TextProbe\Validator\Identity;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for Russian internal passport numbers.
 *
 * This validator normalizes input by removing non-digit characters, checks
 * that the passport consists of exactly 10 digits, ensures the region code is
 * not "00", and rejects numbers where the serial part is all zeros. The goal
 * is to filter out obvious false positives while keeping common passport
 * formats.
 */
class RussianPassportNumberValidator implements IValidator
{
    /**
     * Validates a raw passport number string.
     *
     * @param string $raw Raw passport number as found in text (may include spaces or dashes)
     *
     * @return bool true if the passport number follows expected length and series rules, false otherwise
     */
    public function validate(string $raw): bool
    {
        $normalized = preg_replace('/\D+/', '', $raw);

        if (!isset($normalized) || strlen($normalized) !== 10) {
            return false;
        }

        $region = substr($normalized, 0, 2);
        $serial = substr($normalized, 4);

        if ($region === '00') {
            return false;
        }

        return !($serial === '000000');
    }
}
