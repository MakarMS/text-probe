<?php

namespace TextProbe\Validator\Finance\Bank\Account;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for IBAN (International Bank Account Number) strings.
 *
 * This validator:
 * - normalizes input (trims, removes spaces, uppercases),
 * - checks basic structural format (country code, checksum, length),
 * - verifies the Mod-97 checksum according to the IBAN specification,
 * implemented without relying on arbitrary-precision extensions.
 */
class BankIbanNumberValidator implements IValidator
{
    /**
     * Validates a raw IBAN string.
     *
     * @param string $raw raw IBAN value as found in text (may contain spaces, mixed case)
     *
     * @return bool true if the IBAN is structurally valid and passes the Mod-97 check,
     *              false otherwise
     */
    public function validate(string $raw): bool
    {
        $iban = $this->normalize($raw);

        if ($iban === '' || !$this->hasValidFormat($iban)) {
            return false;
        }

        return $this->checkMod97($iban);
    }

    /**
     * Normalizes an IBAN string by trimming, removing spaces and uppercasing.
     *
     * @param string $iban raw IBAN string
     *
     * @return string normalized IBAN
     */
    private function normalize(string $iban): string
    {
        return strtoupper(str_replace(' ', '', trim($iban)));
    }

    /**
     * Checks the basic structural format of the IBAN (country code, checksum, length).
     *
     * @param string $iban normalized IBAN
     *
     * @return bool true if the format matches the expected IBAN pattern
     */
    private function hasValidFormat(string $iban): bool
    {
        return (bool) preg_match('/^[A-Z]{2}\d{2}[A-Z0-9]{10,30}$/', $iban);
    }

    /**
     * Performs the Mod-97 checksum validation according to the IBAN standard.
     *
     * IBAN is rearranged (first 4 characters moved to the end), then each character
     * is converted to digits and processed as a long integer modulo 97. A valid IBAN
     * must yield remainder 1.
     *
     * @param string $iban normalized IBAN
     *
     * @return bool true if the Mod-97 result is 1, false otherwise
     */
    private function checkMod97(string $iban): bool
    {
        $rearranged = substr($iban, 4) . substr($iban, 0, 4);
        $mod97 = 0;

        foreach (str_split($rearranged) as $char) {
            $mod97 = $this->processChar($mod97, $char);
        }

        return $mod97 === 1;
    }

    /**
     * Processes a single character of the rearranged IBAN in the Mod-97 loop.
     *
     * For digits, it appends the digit; for letters, it converts the letter to
     * its numeric counterpart (A=10, B=11, ..., Z=35) and processes each digit.
     *
     * @param int    $mod97 current modulo value
     * @param string $char  single character from the rearranged IBAN
     *
     * @return int updated modulo value after incorporating the character
     */
    private function processChar(int $mod97, string $char): int
    {
        if ($char >= '0' && $char <= '9') {
            return ($mod97 * 10 + (int) $char) % 97;
        }

        $numericValue = ord($char) - 55;
        foreach (str_split((string) $numericValue) as $digitChar) {
            $mod97 = ($mod97 * 10 + (int) $digitChar) % 97;
        }

        return $mod97;
    }
}
