<?php

namespace TextProbe\Probes\Geo;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts postal codes from text.
 *
 * Supports multiple international formats, including:
 * - Russian six-digit postal codes (e.g. "123456")
 * - US ZIP codes with optional +4 extension (e.g. "12345" or "12345-6789")
 * - UK formats like "SW1A 1AA" (case-insensitive, with optional spaces)
 * - Canadian alphanumeric codes (e.g. "M5V 3L9" or "K1A-0B1")
 * - Dutch-style codes with trailing letters (e.g. "1012 AB" or "1012AB")
 */
class PostalCodeProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/\b('
            . '\d{5}(?:-\d{4})?'
            . '|'
            . '\d{6}'
            . '|'
            . '[A-Z]{1,2}\d[A-Z\d]?\s*\d[A-Z]{2}'
            . '|'
            . '[ABCEGHJ-NPRSTVXY]\d[ABCEGHJ-NPRSTV-Z][\s-]?\d[ABCEGHJ-NPRSTV-Z]\d'
            . '|'
            . '\d{4}\s?[A-Z]{2}'
            . ')\b/iu',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::POSTAL_CODE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::POSTAL_CODE;
    }
}
