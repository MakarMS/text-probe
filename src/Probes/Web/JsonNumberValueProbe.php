<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts JSON numeric values.
 */
class JsonNumberValueProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^-?(?:0|[1-9]\d*)(?:\.\d+)?(?:[eE][+-]?\d+)?$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::JSON_NUMBER_VALUE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::JSON_NUMBER_VALUE;
    }
}
