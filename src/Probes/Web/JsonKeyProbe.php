<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts unquoted JSON-like keys.
 */
class JsonKeyProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Za-z_][A-Za-z0-9_]*(?=\s*:)/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::JSON_KEY
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::JSON_KEY;
    }
}
