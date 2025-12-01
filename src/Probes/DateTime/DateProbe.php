<?php

namespace TextProbe\Probes\DateTime;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts dates in various human-readable formats.
 *
 * This probe supports ISO-like numeric dates (e.g. "2023-10-21"), common
 * separator-based formats such as "DD/MM/YYYY" or "DD.MM.YY", and textual
 * dates like "2nd Jan 2023".
 */
class DateProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/\b('
            . '\d{4}-\d{2}-\d{2}'
            . '|'
            . '\d{1,2}[\/.\-]\d{1,2}[\/.\-]\d{2,4}'
            . '|'
            . '\d{1,2}(?:st|nd|rd|th)?\s+'
            . '(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*[ ,]\s?\d{2,4}'
            . ')\b/ix',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::DATE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DATE;
    }
}
