<?php

namespace TextProbe\Validator\Identity\TaxNumber;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for Norwegian fødselsnummer.
 */
class NoFoedselsnummerChecksumValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        if (preg_match('/^\d{11}$/', $raw) !== 1) {
            return false;
        }

        $k1 = $this->calculateChecksum($raw, [3, 7, 6, 1, 8, 9, 4, 5, 2], 9);

        if ($k1 === null || $k1 !== (int) $raw[9]) {
            return false;
        }

        $k2 = $this->calculateChecksum($raw, [5, 4, 3, 2, 7, 6, 5, 4, 3, 2], 10);

        return $k2 !== null && $k2 === (int) $raw[10];
    }

    /**
     * @param list<int> $weights
     */
    private function calculateChecksum(string $raw, array $weights, int $length): ?int
    {
        $sum = 0;
        foreach ($weights as $index => $weight) {
            if ($index >= $length) {
                break;
            }
            $sum += ((int) $raw[$index]) * $weight;
        }

        $mod = $sum % 11;

        if ($mod === 0) {
            return 0;
        }

        if ($mod === 1) {
            return null;
        }

        return 11 - $mod;
    }
}
