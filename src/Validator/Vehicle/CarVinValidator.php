<?php

namespace TextProbe\Validator\Vehicle;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for Vehicle Identification Numbers (VIN).
 *
 * Ensures VIN length, allowed characters (excluding I, O, Q), and validates
 * the ISO 3779 check digit found at the 9th position.
 */
class CarVinValidator implements IValidator
{
    private const VIN_LENGTH = 17;

    /**
     * Transliteration map as defined by the VIN standard.
     *
     * Digits map to themselves while letters map to numeric weights used for
     * calculating the checksum.
     */
    private const TRANSLITERATION = [
        'A' => 1,
        'B' => 2,
        'C' => 3,
        'D' => 4,
        'E' => 5,
        'F' => 6,
        'G' => 7,
        'H' => 8,
        'J' => 1,
        'K' => 2,
        'L' => 3,
        'M' => 4,
        'N' => 5,
        'P' => 7,
        'R' => 9,
        'S' => 2,
        'T' => 3,
        'U' => 4,
        'V' => 5,
        'W' => 6,
        'X' => 7,
        'Y' => 8,
        'Z' => 9,
        '0' => 0,
        '1' => 1,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
    ];

    /**
     * Position-specific weights used to compute the VIN checksum.
     */
    private const WEIGHTS = [8, 7, 6, 5, 4, 3, 2, 10, 0, 9, 8, 7, 6, 5, 4, 3, 2];

    public function validate(string $raw): bool
    {
        $vin = strtoupper($raw);

        if (strlen($vin) !== self::VIN_LENGTH) {
            return false;
        }

        if (preg_match('/^[A-HJ-NPR-Z0-9]{17}$/', $vin) === false) {
            return false;
        }

        $expectedCheckDigit = $vin[8];
        $calculatedCheckDigit = $this->calculateCheckDigit($vin);

        return $expectedCheckDigit === $calculatedCheckDigit;
    }

    private function calculateCheckDigit(string $vin): string
    {
        $sum = 0;

        foreach (str_split($vin) as $index => $char) {
            $value = self::TRANSLITERATION[$char] ?? null;

            if ($value === null || !isset(self::WEIGHTS[$index])) {
                return '';
            }

            $sum += $value * self::WEIGHTS[$index];
        }

        $remainder = $sum % 11;

        return $remainder === 10 ? 'X' : (string) $remainder;
    }
}
