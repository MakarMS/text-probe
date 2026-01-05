<?php

namespace TextProbe\Probes\Finance\Swift;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts SWIFT UETR identifiers.
 */
class UetrProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[1-8][0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SWIFT_UETR
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SWIFT_UETR;
    }
}
