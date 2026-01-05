<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts JSON string values.
 */
class JsonStringValueProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^"(?:\\\\.|[^"\\\\])*"$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::JSON_STRING_VALUE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::JSON_STRING_VALUE;
    }
}
