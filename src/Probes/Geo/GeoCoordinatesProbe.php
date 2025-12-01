<?php

namespace TextProbe\Probes\Geo;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts geographic coordinates from text.
 *
 * This probe supports:
 * - Decimal degrees (e.g. "55.7558, 37.6173" or "-34.6037; -58.3816")
 * - Degrees and minutes (DMM) with optional N/S/E/W suffixes
 * - Degrees, minutes and seconds (DMS) with optional N/S/E/W suffixes
 *
 * It recognises common separators such as commas, semicolons and whitespace
 * between latitude and longitude components.
 */
class GeoCoordinatesProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/('
            . '-?(?:[0-8]?\d(?:\.\d+)?|90(?:\.0+)?)\s*[,;\s]\s*-?(?:1[0-7]\d(?:\.\d+)?|180(?:\.0+)?|[0-9]?\d(?:\.\d+)?)'
            . '|'
            . '\d{1,2}°\s*\d{1,2}(?:\.\d+)?[\'′’]?\s*[NS]?\s*[,;\s]\s*\d{1,3}°\s*\d{1,2}(?:\.\d+)?[\'′’]?\s*[EW]?'
            . '|'
            . '\d{1,2}°\s*\d{1,2}[\'′’]?\s*\d{1,2}(?:\.\d+)?[\"″]?\s*[NS]?\s*[,;\s]\s*\d{1,3}°\s*\d{1,2}[\'′’]?\s*\d{1,2}(?:\.\d+)?[\"″]?\s*[EW]?'
            . ')/xiu',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::GEO_COORDINATES
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GEO_COORDINATES;
    }
}
