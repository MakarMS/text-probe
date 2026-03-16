<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts HTTP status lines.
 */
class HttpStatusLineProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^HTTP\/\d(?:\.\d)?\s[1-5]\d{2}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::HTTP_STATUS_LINE
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HTTP_STATUS_LINE;
    }
}
