<?php

namespace TextProbe\Validator\Identity;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for Russian Tax Identification Numbers (INN).
 *
 * Supports both 10-digit organization INNs and 12-digit individual INNs,
 * applying the official checksum formulas to minimize false positives.
 */
class InnValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $inn = $this->normalize($raw);

        if ($inn === null) {
            return false;
        }

        if (!$this->hasValidLength($inn)) {
            return false;
        }

        $digits = array_map('intval', str_split($inn));

        return strlen($inn) === 10
            ? $this->validateLegalEntityInn($digits)
            : $this->validateIndividualInn($digits);
    }

    private function normalize(string $inn): ?string
    {
        return preg_replace('/\D+/', '', $inn);
    }

    private function hasValidLength(string $inn): bool
    {
        $length = strlen($inn);

        return $length === 10 || $length === 12;
    }

    /**
     * Validates a 10-digit legal entity INN.
     *
     * Control digit (10th) uses weights [2,4,10,3,5,9,4,6,8].
     *
     * @param list<int> $digits
     */
    private function validateLegalEntityInn(array $digits): bool
    {
        if (count($digits) !== 10) {
            return false;
        }

        $weights = [2, 4, 10, 3, 5, 9, 4, 6, 8];
        $checksum = $this->calculateChecksum($digits, $weights);

        return $checksum === $digits[9];
    }

    /**
     * Validates a 12-digit individual INN.
     *
     * Control digits use weights:
     * - 11th digit: [7,2,4,10,3,5,9,4,6,8]
     * - 12th digit: [3,7,2,4,10,3,5,9,4,6,8,0] (last weight unused but keeps indexes aligned)
     *
     * @param list<int> $digits
     */
    private function validateIndividualInn(array $digits): bool
    {
        if (count($digits) !== 12) {
            return false;
        }

        $firstChecksum = $this->calculateChecksum($digits, [7, 2, 4, 10, 3, 5, 9, 4, 6, 8]);
        $secondChecksum = $this->calculateChecksum($digits, [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8, 0]);

        return $firstChecksum === $digits[10] && $secondChecksum === $digits[11];
    }

    /**
     * @param list<int> $digits
     * @param list<int> $weights
     */
    private function calculateChecksum(array $digits, array $weights): int
    {
        $sum = 0;

        foreach ($weights as $index => $weight) {
            if (!isset($digits[$index])) {
                return 0;
            }

            $sum += $weight * $digits[$index];
        }

        return ($sum % 11) % 10;
    }
}
