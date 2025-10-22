<?php

namespace TextProbe\Probes\DateTime;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

class DateTimeProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/\b('
            . '\d{1,2}:\d{2}(?::\d{2}(?:\.\d{1,3})?)?\s?(?:AM|PM)?\s+\d{4}-\d{2}-\d{2}'
            . '|'
            . '\d{1,2}:\d{2}(?::\d{2}(?:\.\d{1,3})?)?\s?(?:AM|PM)?\s+\d{1,2}[\/.\-]\d{1,2}[\/.\-]\d{2,4}'
            . '|'
            . '\d{1,2}:\d{2}(?::\d{2}(?:\.\d{1,3})?)?\s?(?:AM|PM)?\s+\d{1,2}(?:st|nd|rd|th)?\s+(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*\s+\d{4}'
            . '|'
            . '\d{4}-\d{2}-\d{2}[ T]\d{2}:\d{2}(?::\d{2}(?:\.\d{1,3})?)?(?:\s?[AP]M)?'
            . '|'
            . '\d{1,2}[\/.\-]\d{1,2}[\/.\-]\d{2,4}\s+\d{1,2}:\d{2}(?::\d{2}(?:\.\d{1,3})?)?(?:\s?[AP]M)?'
            . '|'
            . '\d{1,2}(?:st|nd|rd|th)?\s+(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*\s+\d{4}\s+\d{1,2}:\d{2}(?::\d{2}(?:\.\d{1,3})?)?(?:\s?[AP]M)?'
            . ')\b/i',
            $text
        );
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DATETIME;
    }
}
