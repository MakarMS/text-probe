<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts JSON boolean values.
 */
class JsonBooleanValueProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^(?:true|false)$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::JSON_BOOLEAN_VALUE
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::JSON_BOOLEAN_VALUE;
    }
}
