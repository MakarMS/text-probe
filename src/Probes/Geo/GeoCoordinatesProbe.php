<?php

namespace TextProbe\Probes\Geo;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

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

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GEO_COORDINATES;
    }
}
