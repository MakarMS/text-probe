<?php

namespace TextProbe\Probes\DateTime;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts time values from text.
 *
 * This probe supports times like "14:30", "14:30:15", and "14:30:15.123"
 * with optional AM/PM markers, while trying to respect word boundaries
 * and common separators.
 */
class TimeProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/\b\d{1,2}:\d{2}(?::\d{2}(?:\.\d+)?)?\s*(?:AM|PM)?(?=[\s,;]|$)/i',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::TIME
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TIME;
    }
}
