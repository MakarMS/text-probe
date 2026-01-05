<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts JSON null values.
 */
class JsonNullValueProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^null$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::JSON_NULL_VALUE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::JSON_NULL_VALUE;
    }
}
