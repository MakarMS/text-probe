<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts quoted JSON keys.
 */
class JsonQuotedKeyProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^"(?:\\\\.|[^"\\\\])*"(?=\s*:)/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::JSON_QUOTED_KEY
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::JSON_QUOTED_KEY;
    }
}
