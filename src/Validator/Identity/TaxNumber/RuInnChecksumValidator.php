<?php

namespace TextProbe\Validator\Identity\TaxNumber;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for Russian tax identification numbers (INN).
 */
class RuInnChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        if (preg_match('/^(?:\d{10}|\d{12})$/', $raw) !== 1) {
            return false;
        }

        $values = array_map('intval', str_split($raw));

        return strlen($raw) === 10
            ? $this->validateLegalEntityInn($values)
            : $this->validateIndividualInn($values);
    }

    /**
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
