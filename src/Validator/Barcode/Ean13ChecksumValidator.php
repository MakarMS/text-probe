<?php

namespace TextProbe\Validator\Barcode;

use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Validates EAN-13 barcodes using the standard checksum algorithm.
 */
class Ean13ChecksumValidator implements IValidator
{
    #[Override]
    public function validate(string $raw): bool
    {
        if (preg_match('/^\d{13}$/', $raw) !== 1) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $digit = (int) $raw[$i];
            $sum += ($i % 2 === 0) ? $digit : $digit * 3;
        }

        $check = (10 - ($sum % 10)) % 10;

        return $check === (int) $raw[12];
    }
}
